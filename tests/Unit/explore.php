<?php

use MiroClipboard\Enums\LineCap;
use MiroClipboard\Enums\LineType;
use MiroClipboard\Enums\ShapeType;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLineText;
use MiroClipboard\Styles\MiroLineStyle;
use MiroClipboard\Styles\MiroShapeStyle;

test('playground', function() {
    $shape = MiroWidget::make()
        ->shape(ShapeType::Star)
        ->text('Hello!')
        ->scale(.5)
        ->rotation(90)
        ->offsetPosition(50, 50)
        ->style(fn(MiroShapeStyle $style) => $style
            ->backgroundColor('#FF0000')
            ->textColor('#00FF00')
        );

    $line =  MiroWidget::make()
        ->line()
        ->start(-100, 0)
        ->addPoint(50, 50)
        ->end(100, 100)
        ->addText(MiroLineText::make('woooow', .75, .5)->rotated())
        ->addText(MiroLineText::make('123', .25, .5))
        ->style(fn(MiroLineStyle $style) => $style
            ->color('#F0FF00')
            ->startingLinecap(LineCap::Circle)
            ->endingLinecap(LineCap::DiamondFilled)
            ->strokeWeight(4)
            ->type(LineType::Square)
            ->jump()
        );

    dd(
        MiroClipboardData::make()
            ->addGroup([$shape, $line])
            ->toHTML()
    );

    dd(
        MiroClipboardData::make()
            ->addObject(MiroWidget::make()
                ->line()
                ->start(-100, 0)
                ->addPoint(50, 50)
                ->end(100, 100)
                ->addText(MiroLineText::make('woooow', .75, .5)->rotated())
                ->addText(MiroLineText::make('123', .25, .5))
                ->style(fn(MiroLineStyle $style) => $style
                    ->color('#F0FF00')
                    ->startingLinecap(LineCap::Circle)
                    ->endingLinecap(LineCap::DiamondFilled)
                    ->strokeWeight(4)
                    ->type(LineType::Square)
                    ->jump()
                )
            )
            ->toHTML()
    );

    dd(
        MiroClipboardData::make()
            ->addObject(MiroWidget::make()
                ->shape(ShapeType::Star)
                ->text('Hello!')
                ->scale(.5)
                ->rotation(90)
                ->style(fn(MiroShapeStyle $style) => $style
                    ->backgroundColor('#FF0000')
                    ->textColor('#00FF00')
                )
            )
            ->toHTML()
    );
});
