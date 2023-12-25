<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Enums\ObjectType;

abstract class MiroObject
{
    public function __construct(
        protected int $id,
        protected string $initialId,
        protected ObjectType $type,
    ) {
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
