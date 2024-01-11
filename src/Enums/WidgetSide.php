<?php

namespace MiroClipboard\Enums;

enum WidgetSide
{
    case Top;
    case Bottom;
    case Left;
    case Right;

    public function pointForSide(float $offset = 0.5): array
    {
        assert($offset >= 0, 'offset must be greater than or equal to 0');
        assert($offset <= 1, 'offset must be less than or equal to 1');

        return match ($this) {
            WidgetSide::Top    => [
                'x' => $offset,
                'y' => 0,
            ],
            WidgetSide::Bottom => [
                'x' => $offset,
                'y' => 1,
            ],
            WidgetSide::Left   => [
                'x' => 0,
                'y' => $offset,
            ],
            WidgetSide::Right  => [
                'x' => 1,
                'y' => $offset,
            ],
        };
    }
}
