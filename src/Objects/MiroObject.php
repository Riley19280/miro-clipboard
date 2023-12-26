<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Enums\ObjectType;

abstract class MiroObject
{
    protected int $id;
    protected string $initialId;

    public function __construct(
        protected ObjectType $type,
    ) {
        $this->id        = random_int(1, 100000000);
        $this->initialId = (string)$this->id;
    }

    public function id(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function initialId(string $initialId): static
    {
        $this->initialId = $initialId;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'initialId' => $this->initialId,
            'type'      => $this->type->value,
        ];
    }
}
