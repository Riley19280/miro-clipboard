<?php

namespace MiroClipboard;

use MiroClipboard\Enums\WidgetType;
use MiroClipboard\Exceptions\ParserNotResolvedException;
use MiroClipboard\Objects\MiroObject;
use MiroClipboard\Parsers\LineParser;
use MiroClipboard\Parsers\MiroParserInterface;
use MiroClipboard\Parsers\ShapeParser;

use function MiroClipboard\MiroUtility\decodeMiroDataString;

class MiroParser
{
    /**
     * @param string $data
     *
     * @throws ParserNotResolvedException
     *
     * @return MiroObject[]
     */
    public static function parse(string $data): array
    {
        $arrayData = decodeMiroDataString($data);

        $objects = [];

        foreach ($arrayData['data']['objects'] as $objectData) {
            $parser    = self::resolveParser($objectData);
            $objects[] = $parser::parse($objectData);
        }

        return $objects;
    }

    public static function resolveParser(array $data): MiroParserInterface
    {
        $widgetType = WidgetType::tryFrom($data['widgetData']['type']);

        return match ($widgetType) {
            WidgetType::Shape => new ShapeParser(),
            WidgetType::Line  => new LineParser(),
            default           => throw new ParserNotResolvedException($data['widgetData']['type'] ?? 'null'),
        };
    }
}
