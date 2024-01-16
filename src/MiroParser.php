<?php

namespace MiroClipboard;

use MiroClipboard\Enums\ObjectType;
use MiroClipboard\Enums\WidgetType;
use MiroClipboard\Exceptions\ParserNotResolvedException;
use MiroClipboard\Parsers\GroupParser;
use MiroClipboard\Parsers\LineParser;
use MiroClipboard\Parsers\MiroParserInterface;
use MiroClipboard\Parsers\ShapeParser;
use MiroClipboard\Utility\HasGroup;

use function MiroClipboard\MiroUtility\decodeMiroDataString;

class MiroParser
{
    /**
     * @param string|array $data
     *
     * @throws ParserNotResolvedException
     *
     * @return MiroClipboardData
     */
    public static function parse(string|array $data): MiroClipboardData
    {
        if (is_string($data)) {
            $arrayData = decodeMiroDataString($data);
        } else {
            $arrayData = $data;
        }

        $newClipboardData = MiroClipboardData::make();

        foreach ($arrayData['data']['objects'] as $objectData) {
            $parser = self::resolveParser($objectData);
            $newClipboardData->addObject($parser::parse($objectData));
        }

        foreach ($newClipboardData->getObjects() as $object) {
            if (method_exists($object, 'resolveClipboardDataReferences')) {
                $object->resolveClipboardDataReferences($newClipboardData);
            }
            if (in_array(HasGroup::class, class_uses($object))) {
                $object->resolveGroupClipboardDataReferences($newClipboardData);
            }
        }

        return $newClipboardData;
    }

    public static function resolveParser(array $data): MiroParserInterface
    {
        return match (ObjectType::tryFrom($data['type'])) {
            ObjectType::Object => self::resolveWidgetParser($data),
            ObjectType::Group  => new GroupParser(),
            default            => throw new ParserNotResolvedException($data['type'] ?? 'null'),
        };
    }

    private static function resolveWidgetParser(array $data): MiroParserInterface
    {
        $widgetType = WidgetType::tryFrom($data['widgetData']['type']);

        return match ($widgetType) {
            WidgetType::Shape => new ShapeParser(),
            WidgetType::Line  => new LineParser(),
            default           => throw new ParserNotResolvedException($data['widgetData']['type'] ?? 'null'),
        };
    }
}
