<?php

namespace MiroClipboard;

use MiroClipboard\Objects\MiroGroup;
use MiroClipboard\Objects\MiroObject;
use MiroClipboard\Utility\Makeable;

use function MiroClipboard\MiroUtility\encodeMiroData;

/**
 * @phpstan-consistent-constructor
 */
class MiroClipboardData
{
    use Makeable;

    private string $boardId;
    private string $host      = 'miro.com';
    private bool $isProtected = false;
    private int $version      = 2;

    /**
     * @var array<MiroObject>
     */
    private array $objects = [];

    public function __construct()
    {
        $this->boardId = bin2hex(random_bytes(16));
    }

    public function boardId(string $id): static
    {
        $this->boardId = $id;

        return $this;
    }

    public function addObject(MiroObject $object): static
    {
        if ($object instanceof MiroGroup) {
            return $this->addGroup($object);
        }

        $this->objects[] = $object;

        return $this;
    }

    /**
     * @param MiroObject[] $group
     *
     * @return $this
     */
    public function addGroup(MiroGroup|array $group): static
    {
        if ($group instanceof MiroGroup) { // Is an existing group
            $this->addExistingGroup($group);
        } else { // Creating a new group from an array of objects
            $this->addNewGroupFromItems($group);
        }

        return $this;
    }

    private function addNewGroupFromItems(array $groupItems): void
    {
        $group = MiroGroup::make();
        foreach ($groupItems as $groupItem) {
            $group->add($groupItem);
        }

        $this->addExistingGroup($group);
    }

    private function addExistingGroup(MiroGroup $group): void
    {
        foreach ($group->getObjects() as $groupItem) {
            $this->addObject($groupItem);
        }
        $this->objects[] = $group;
    }

    public function getObjects(): array
    {
        return $this->objects;
    }

    public static function parse(string $data): MiroClipboardData
    {
        return MiroParser::parse($data);
    }

    public function toArray(): array
    {
        return [
            'boardId'     => $this->boardId,
            'data'        => [
                'meta'    => [],
                'objects' => array_map(fn(MiroObject $object) => $object->toArray(), $this->objects),
            ],
            'host'        => $this->host,
            'version'     => $this->version,
            'isProtected' => $this->isProtected,
        ];
    }

    public function toHTML(): string
    {
        return encodeMiroData($this->toArray());
    }
}
