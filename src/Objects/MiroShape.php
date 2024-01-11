<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Enums\ShapeType;
use MiroClipboard\Enums\WidgetType;
use MiroClipboard\MiroWidget;
use MiroClipboard\Styles\MiroShapeStyle;
use MiroClipboard\Utility\SetPropertiesFromArray;

class MiroShape extends MiroWidget
{
    use SetPropertiesFromArray;

    private MiroShapeStyle $shapeStyle;

    private ShapeType $shapeType;

    private string $text = '';

    private array $size = [
        'width'  => 100,
        'height' => 100,
    ];

    private array $position = [
        'x' => 0.0,
        'y' => 0.0,
    ];

    private array $offsetPosition = [
        'x' => 0.0,
        'y' => 0.0,
    ];

    private float $scale = 1;

    private float $relativeScale = 1;

    private float $rotation = 0;

    private float $relativeRotation = 0;

    public function __construct(ShapeType $shapeType = ShapeType::Square)
    {
        parent::__construct();

        $this->widgetType = WidgetType::Shape;

        $this->shapeType = $shapeType;

        $this->shapeStyle = new MiroShapeStyle();
    }

    /**
     * @param callable(MiroShapeStyle): static $style
     *
     * @return $this
     */
    public function style(callable $style): static
    {
        $style($this->shapeStyle);

        return $this;
    }

    public function text(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function size(int $width, int $height): static
    {
        $this->size = [
            'width'  => $width,
            'height' => $height,
        ];

        return $this;
    }

    public function scale(float $scale): static
    {
        $this->scale = $scale;

        return $this;
    }

    public function relativeScale(float $relativeScale): static
    {
        $this->relativeScale = $relativeScale;

        return $this;
    }

    public function rotation(float $rotation): static
    {
        $this->rotation = $rotation;

        return $this;
    }

    public function relativeRotation(float $relativeRotation): static
    {
        $this->relativeRotation = $relativeRotation;

        return $this;
    }

    public function position(float $x, float $y): static
    {
        $this->position = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function offsetPosition(float $x, float $y): static
    {
        $this->offsetPosition = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'widgetData' => [
                'type' => $this->widgetType->value,
                'json' => [
                    'size'             => $this->size,
                    '_position'        => [
                        'offsetPx' => $this->offsetPosition,
                    ],
                    'scale'            => [
                        'scale' => $this->scale,
                    ],
                    'relativeScale'    => $this->relativeScale,
                    'rotation'         => [
                        'rotation' => $this->rotation,
                    ],
                    'relativeRotation' => $this->relativeRotation,
                    'position'         => $this->position,
                    '_parent'          => null,
                    'text'             => $this->text,
                    'style'            => json_encode($this->shapeStyle->toArray()),
                    'shape'            => $this->shapeType->value,
                ],
            ],
        ];
    }
}
