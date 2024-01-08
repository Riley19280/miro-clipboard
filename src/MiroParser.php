<?php

namespace MiroClipboard;

use MiroClipboard\Enums\ObjectType;
use MiroClipboard\Enums\WidgetType;
use MiroClipboard\Exceptions\ParserNotResolvedException;
use MiroClipboard\Objects\MiroGroup;
use MiroClipboard\Objects\MiroObject;
use MiroClipboard\Parsers\GroupParser;
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
     * @return MiroClipboardData
     */
    public static function parse(string $data): MiroClipboardData
    {
        $arrayData = decodeMiroDataString($data);

        $newClipboardData = MiroClipboardData::make();

        foreach ($arrayData['data']['objects'] as $objectData) {
            $parser = self::resolveParser($objectData);
            $newClipboardData->addObject($parser::parse($objectData));
        }

        foreach ($newClipboardData->getObjects() as $object) {
            if (!$object instanceof MiroGroup) {
                continue;
            }

            self::resolveGroupReferences($newClipboardData, $object);
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

    private static function resolveGroupReferences(MiroClipboardData $clipboardData, MiroGroup $group): void
    {
        $groupObjectIds = $group->toArray()['items'];

        $groupObjects = array_reduce(
            $clipboardData->getObjects(),
            function(array $ax, MiroObject $object) use ($groupObjectIds) {
                if (in_array($object->toArray()['id'], $groupObjectIds)) {
                    $ax[] = $object;
                }

                return $ax;
            },
            []
        );

        $group->setRawObjects($groupObjects);
    }
}
