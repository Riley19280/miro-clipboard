<?php

namespace MiroClipboard;

use MiroClipboard\Enums\MiroObjectType;
use MiroClipboard\Enums\MiroShapeType;
use MiroClipboard\Enums\MiroWidgetType;

class MiroWidget extends MiroObject
{
    protected MiroWidgetType $widgetType;

    public function __construct(int $id, string $initialId)
    {
        parent::__construct($id, $initialId, MiroObjectType::Object);
    }

    public function type(MiroWidgetType $type): static
    {
        $this->widgetType = $type;

        return $this;
    }

    public function shape(MiroShapeType $shapeType = MiroShapeType::Square): MiroShape
    {
        return new MiroShape($shapeType, $this->id, $this->initialId);
    }

    public function line(): MiroLine
    {
        return new MiroLine($this->id, $this->initialId);
    }
}
