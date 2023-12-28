<?php

use MiroClipboard\Enums\BorderStyle;
use MiroClipboard\Enums\LineCap;
use MiroClipboard\Enums\LinePattern;
use MiroClipboard\Enums\LineType;
use MiroClipboard\Enums\ShapeType;
use MiroClipboard\Enums\TextAlign;
use MiroClipboard\Enums\VerticalTextAlign;
use MiroClipboard\Exceptions\ParserNotResolvedException;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroParser;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLineText;
use MiroClipboard\Objects\MiroShape;
use MiroClipboard\Parsers\LineParser;
use MiroClipboard\Parsers\ShapeParser;
use MiroClipboard\Styles\MiroLineStyle;
use MiroClipboard\Styles\MiroShapeStyle;

test('parse', function() {
    $shape = MiroWidget::make()->shape();

    $result = MiroParser::parse(MiroClipboardData::make()->addObject($shape)->toHTML());

    expect($result[0])->toBeInstanceOf(MiroShape::class);
});

test('resolve parser', function() {
    $shape = MiroWidget::make()->shape();
    expect(MiroParser::resolveParser($shape->toArray()))->toBeInstanceOf(ShapeParser::class);

    $line = MiroWidget::make()->line();
    expect(MiroParser::resolveParser($line->toArray()))->toBeInstanceOf(LineParser::class);

});

test('invalid parser', function() {
    $invalid = ['widgetData' => ['type' => 'unknown']];

    MiroParser::resolveParser($invalid);
})->expectException(ParserNotResolvedException::class);

test('shape parser', function() {
    $shape = MiroWidget::make()
        ->shape(ShapeType::Star)
        ->text('Hello!')
        ->scale(.5)
        ->relativeScale(.5)
        ->rotation(90)
        ->relativeRotation(90)
        ->offsetPosition(50, 50)
        ->position(50, 50)
        ->size(50, 50)
        ->style(fn(MiroShapeStyle $style) => $style
            ->backgroundColor(16711680)->backgroundColor('#FF0000')
            ->backgroundOpacity(.5)
            ->borderColor(16711680)->borderColor('#FF0000')
            ->borderThickness(5)
            ->borderOpacity(.5)
            ->borderStyle(BorderStyle::DashLong)
            ->fontFamily('Arial')
            ->textColor(16711680)->textColor('#FF0000')
            ->textAlign(TextAlign::Left, VerticalTextAlign::Top)
            ->fontSize(11)
            ->bold()
            ->italic()
            ->underline()
            ->strikethrough()
        );

    expect(ShapeParser::parse($shape->toArray())->toArray())->toBe($shape->toArray());
});

test('line parser', function() {
    $line = MiroWidget::make()
        ->line()
        ->addText(
            MiroLineText::make('Hello', .5, .5)
                ->color('#FF0000')
                ->color(16711680)
                ->rotated()
                ->fontSize(11)
                ->width(50)
        )
        ->setPoints([
            ['x' => 111.0, 'y' => 111.0],
            ['x' => 123.0, 'y' => 123.0],
            ['x' => 456.0, 'y' => 456.0],
            ['x' => 500.0, 'y' => 500.0],
        ])
        ->style(fn(MiroLineStyle $lineStyle) => $lineStyle
            ->jump()
            ->type(LineType::Square)
            ->strokeWeight(4)
            ->color('#FF0000')
            ->color(16711680)
            ->startingLinecap(LineCap::Circle)
            ->endingLinecap(LineCap::CircleFilled)
            ->pattern(LinePattern::Dotted)
        );

    expect(LineParser::parse($line->toArray())->toArray())->toBe($line->toArray());
});
