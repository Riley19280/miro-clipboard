<?php

use MiroClipboard\Enums\LineCap;
use MiroClipboard\Enums\LinePattern;
use MiroClipboard\Enums\LineType;
use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLine;
use MiroClipboard\Objects\MiroLineText;
use MiroClipboard\Styles\MiroLineStyle;

test('set start', function() {
    $data = (MiroLine::make())->start(123, 123);
    expect($data->toArray()['widgetData']['json']['primary']['point'])->toBe(['x' => 123.0, 'y' => 123.0]);
});

test('set end', function() {
    $data = (MiroLine::make())->end(123, 123);
    expect($data->toArray()['widgetData']['json']['secondary']['point'])->toBe(['x' => 123.0, 'y' => 123.0]);
});

test('add point', function() {
    $data = (MiroLine::make())->addPoint(123, 123);
    expect($data->toArray()['widgetData']['json']['points'])->toBe([['x' => 123.0, 'y' => 123.0]]);
});

test('set points', function() {
    $data = (MiroLine::make())->setPoints([
        ['x' => 100.0, 'y' => 100.0],
        ['x' => 123.0, 'y' => 123.0],
        ['x' => 456.0, 'y' => 456.0],
        ['x' => 500.0, 'y' => 500.0],
    ]);

    expect($data->toArray()['widgetData']['json']['primary']['point'])->toBe(['x' => 100.0, 'y' => 100.0]);
    expect($data->toArray()['widgetData']['json']['secondary']['point'])->toBe(['x' => 500.0, 'y' => 500.0]);
    expect($data->toArray()['widgetData']['json']['points'])->toBe([['x' => 123.0, 'y' => 123.0], ['x' => 456.0, 'y' => 456.0]]);
});

test('from', function() {
    $object = MiroWidget::make()->shape();
    $data   = (MiroLine::make())->from($object);

    expect($data->toArray()['widgetData']['json']['primary']['widgetIndex'])->toBe($object->getId());
});

test('to', function() {
    $object = MiroWidget::make()->shape();
    $data   = (MiroLine::make())->to($object);

    expect($data->toArray()['widgetData']['json']['secondary']['widgetIndex'])->toBe($object->getId());
});

test('to and from are added to clipboard data', function() {
    $data = MiroClipboardData::make()
        ->addObject(MiroWidget::make()->line()
            ->from(MiroWidget::make()->shape()->text('1'))
            ->to(MiroWidget::make()->shape()->text('2'))
        );

    expect($data->getObjects())->toHaveCount(3);
});

test('add text', function() {
    $data = (MiroLine::make())->addText(
        MiroLineText::make('Hello', .5, .5)
            ->color('#FF0000')
            ->color(16711680)
            ->rotated()
            ->fontSize(11)
            ->width(50)
    );
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['text'])->toBe('Hello');
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['position'])->toBe(['x' => .5, 'y' => .5]);
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['color'])->toBe(16711680);
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['rotated'])->toBe(true);
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['fontSize'])->toBe(11);
    expect($data->toArray()['widgetData']['json']['line']['captions'][0]['width'])->toBe(50);
});

test('set jump style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->jump());
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['jump'])->toBe(1);
});

test('set line type style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->type(LineType::Square));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['lt'])->toBe(LineType::Square->value);
});

test('set stroke weight style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->strokeWeight(4));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['t'])->toBe(4);
});

test('set color style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->color('#FF0000'));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['lc'])->toBe(16711680);

    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->color(16711680));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['lc'])->toBe(16711680);
});

test('set start linecap style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->startingLinecap(LineCap::Circle));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['a_start'])->toBe(LineCap::Circle->value);
});

test('set end linecap style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->endingLinecap(LineCap::CircleFilled));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['a_end'])->toBe(LineCap::CircleFilled->value);
});

test('set line pattern style', function() {
    $data = (MiroLine::make())->style(fn(MiroLineStyle $style) => $style->pattern(LinePattern::Dotted));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['ls'])->toBe(LinePattern::Dotted->value);
});
