<?php

namespace MiroClipboard\Parsers;

use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLine;
use MiroClipboard\Objects\MiroLineText;
use MiroClipboard\Styles\MiroLineStyle;

class LineParser implements MiroParserInterface
{
    public static function parse(array $data): MiroLine
    {
        $newLine = MiroWidget::make()
            ->line()
            ->setPropertiesFromArray($data)
            ->setPropertiesFromArray($data['widgetData']['json'])
            ->style(fn(MiroLineStyle $shapeStyle) => $shapeStyle
                ->setPropertiesFromArray(json_decode($data['widgetData']['json']['style'], true))
            );
        foreach ($data['widgetData']['json']['line']['captions'] ?? [] as $captionData) {
            $newLine->addText(MiroLineText::make($captionData['text'], $captionData['position']['x'], $captionData['position']['y'])
                ->setPropertiesFromArray($captionData)
            );
        }

        return $newLine;
    }
}
