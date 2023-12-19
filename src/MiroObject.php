<?php

namespace MiroClipboard;

use MiroClipboard\Enums\MiroObjectType;

abstract class MiroObject
{
    public function __construct(
        protected int $id,
        protected string $initialId,
        protected MiroObjectType $type,
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
