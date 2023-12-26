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

    public function __construct()
    {
        parent::__construct(ObjectType::Object);
    }

    public function type(WidgetType $type): static
    {
        $this->widgetType = $type;

        return $this;
    }

    public function shape(ShapeType $shapeType = ShapeType::Square): MiroShape
    {
        return (new MiroShape($shapeType))
            ->id($this->id)
            ->initialId($this->initialId);
    }

    public function line(): MiroLine
    {
        return (new MiroLine())
            ->id($this->id)
            ->initialId($this->initialId);
    }
}
