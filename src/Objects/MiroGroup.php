<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Enums\ObjectType;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\Utility\Makeable;

class MiroGroup extends MiroObject
{
    use Makeable;

    /**
     * @var array<MiroObject>
     */
    private array $objects = [];

    /**
     * @var array<int>
     */
    private array $ids = [];

    public function __construct()
    {
        parent::__construct(ObjectType::Group);
    }

    /**
     * @param int|MiroObject $object
     *
     * @return $this
     */
    public function add(int|MiroObject $object): static
    {
        if ($object instanceof MiroObject) {
            $this->objects[] = $object;
            $this->ids[]     = $object->id;
        } else {
            $this->ids[] = $object;
        }

        return $this;
    }

    /**
     * @return array<MiroObject>
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * @param MiroClipboardData $clipboardData
     *
     * @return void
     *
     * @internal
     */
    public function resolveClipboardDataReferences(MiroClipboardData $clipboardData): void
    {
        $this->objects = array_reduce(
            $clipboardData->getObjects(),
            function(array $ax, MiroObject $object) {
                if (in_array($object->toArray()['id'], $this->ids)) {
                    $ax[] = $object;
                }

                return $ax;
            },
            []
        );
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'items' => $this->ids,
        ];
    }
}
