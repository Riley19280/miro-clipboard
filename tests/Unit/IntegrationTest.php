<?php

use MiroClipboard\Enums\WidgetSide;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;

test('line connecting shape', function() {
    // This should create 2 squares with a line pointing between them.
    // The line should be from the top left corner to the bottom right

    $data = MiroClipboardData::make()
        ->boardId('line_connection')
        ->addObject(
            MiroWidget::make()
                ->id(1)
                ->initialId(1)
                ->line()
                ->from(
                    MiroWidget::make()
                        ->id(2)
                        ->initialId(2)
                        ->shape()
                        ->text('1'),
                    WidgetSide::Right,
                    0
                )
                ->to(
                    MiroWidget::make()
                        ->id(3)
                        ->initialId(3)
                        ->shape()
                        ->text('2')
                        ->offsetPosition(200, 0),
                    WidgetSide::Left,
                    1
                )
        );

    expect($data->toArray())->toMatchSnapshot();
});
