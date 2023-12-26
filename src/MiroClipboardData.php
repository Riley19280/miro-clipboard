<?php

namespace MiroClipboard;

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

    private array $data = [
        'meta'    => [],
        'objects' => [],
    ];

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
        $this->data['objects'][] = $object->toArray();

        return $this;
    }

    /**
     * @param MiroObject[] $group
     *
     * @return $this
     */
    public function addGroup(array $group): static
    {
        foreach ($group as $groupItem) {
            $this->addObject($groupItem);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'boardId'     => $this->boardId,
            'data'        => $this->data,
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
