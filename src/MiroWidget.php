<?php

namespace MiroClipboard;

use MiroClipboard\Enums\ObjectType;
use MiroClipboard\Enums\ShapeType;
use MiroClipboard\Enums\WidgetType;
use MiroClipboard\Objects\MiroLine;
use MiroClipboard\Objects\MiroObject;
use MiroClipboard\Objects\MiroShape;

class MiroWidget extends MiroObject
{
    protected WidgetType $widgetType;

    public function __construct(int $id, string $initialId)
    {
        parent::__construct($id, $initialId, ObjectType::Object);
    }

    public function type(WidgetType $type): static
    {
        $this->widgetType = $type;

        return $this;
    }

    public function shape(ShapeType $shapeType = ShapeType::Square): MiroShape
    {
        return new MiroShape($shapeType, $this->id, $this->initialId);
    }

    public function line(): MiroLine
    {
        return new MiroLine($this->id, $this->initialId);
    }
}
