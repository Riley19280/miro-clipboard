<?php

namespace MiroClipboard\Parsers;

use MiroClipboard\Enums\ShapeType;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroShape;
use MiroClipboard\Styles\MiroShapeStyle;

class ShapeParser implements MiroParserInterface
{
    public static function parse(array $data): MiroShape
    {
        return (new MiroWidget())
            ->shape(ShapeType::from($data['widgetData']['json']['shape']))
            ->setPropertiesFromArray($data)
            ->setPropertiesFromArray($data['widgetData']['json'], [
                '_position' => fn(MiroShape $shape, mixed $val) => $shape->offsetPosition($val['offsetPx']['x'], $val['offsetPx']['y']),
                'scale'     => fn(MiroShape $shape, mixed $val) => $shape->scale($val['scale']),
                'rotation'  => fn(MiroShape $shape, mixed $val) => $shape->rotation($val['rotation']),
            ])
            ->style(fn(MiroShapeStyle $shapeStyle) => $shapeStyle
                ->setPropertiesFromArray(json_decode($data['widgetData']['json']['style'], true))
            );

    }
}
