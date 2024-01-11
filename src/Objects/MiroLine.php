<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Enums\WidgetSide;
use MiroClipboard\Enums\WidgetType;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;
use MiroClipboard\Styles\MiroLineStyle;
use MiroClipboard\Utility\SetPropertiesFromArray;

class MiroLine extends MiroWidget
{
    use SetPropertiesFromArray;

    private MiroLineStyle $lineStyle;

    /**
     * @var MiroLineText[]
     */
    private array $captions = [];

    private array $points = [];

    private array $primary = [
        'point'        => [
            'x' => -100,
            'y' => 0,
        ],
        'positionType' => 0,
        'widgetIndex'  => -1,
    ];

    private array $secondary = [
        'point'        => [
            'x' => 100,
            'y' => 0,
        ],
        'positionType' => 0,
        'widgetIndex'  => -1,
    ];

    protected ?MiroObject $toObject   = null;
    protected ?MiroObject $fromObject = null;

    public function __construct()
    {
        parent::__construct();

        $this->widgetType = WidgetType::Line;

        $this->lineStyle = new MiroLineStyle();
    }

    /**
     * @param callable(MiroLineStyle): static $style
     *
     * @return $this
     */
    public function style(callable $style): static
    {
        $style($this->lineStyle);

        return $this;
    }

    public function start(float $x, float $y): static
    {
        $this->primary['point'] = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function end(float $x, float $y): static
    {
        $this->secondary['point'] = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function from(MiroObject $object, WidgetSide $widgetSide = WidgetSide::Right, float $offset = 0.5): static
    {
        $this->fromObject = $object;

        $this->primary['widgetIndex'] = $object->id;
        $this->primary['point']       = $widgetSide->pointForSide($offset);

        return $this;
    }

    public function to(MiroObject $object, WidgetSide $widgetSide = WidgetSide::Left, float $offset = 0.5): static
    {
        $this->toObject = $object;

        $this->secondary['widgetIndex'] = $object->id;
        $this->secondary['point']       = $widgetSide->pointForSide($offset);

        return $this;
    }

    public function addPoint(float $x, float $y): static
    {
        $this->points[] = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function setPoints(array $points): static
    {
        assert(count($points) >= 2, 'Must have at least 2 points for start and end');

        $this->start($points[0]['x'], $points[0]['y']);

        for ($i = 1; $i < count($points) - 1; $i++) {
            $this->points[] = $points[$i];
        }

        $this->end($points[count($points) - 1]['x'], $points[count($points) - 1]['y']);

        return $this;
    }

    public function addText(MiroLineText $text): static
    {
        $this->captions[] = $text;

        return $this;
    }

    /**
     * Return a list of objects that *may* need to be added to the clipboard data
     *
     * @return array<MiroObject>
     *
     * @internal
     */
    public function getAdditionalObjects(): array
    {
        return array_filter([
            $this->fromObject,
            $this->toObject,
        ]);
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
        if ($this->primary['widgetIndex'] != -1 && ($existing = $clipboardData->findObject($this->primary['widgetIndex']))) {
            $this->fromObject = $existing;
        }

        if ($this->secondary['widgetIndex'] != -1 && ($existing = $clipboardData->findObject($this->secondary['widgetIndex']))) {
            $this->toObject = $existing;
        }
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'widgetData' => [
                'type' => $this->widgetType->value,
                'json' => [
                    'line'      => [
                        'captions' => array_map(fn(MiroLineText $c) => $c->toArray(), $this->captions),
                    ],
                    'points'    => $this->points,
                    'primary'   => $this->primary,
                    'secondary' => $this->secondary,
                    'style'     => json_encode($this->lineStyle->toArray()),
                ],
            ],
        ];
    }
}
