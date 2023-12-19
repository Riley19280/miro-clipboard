<?php

use MiroClipboard\Enums\BorderStyle;
use MiroClipboard\Enums\MiroShapeType;
use MiroClipboard\Enums\TextAlign;
use MiroClipboard\Enums\VerticalTextAlign;
use MiroClipboard\MiroShape;
use MiroClipboard\MiroShapeStyle;

test('set text', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->text('Hello');
    expect($data->toArray()['widgetData']['json']['text'])->toBe('Hello');
});

test('set size', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->size(123, 123);
    expect($data->toArray()['widgetData']['json']['size'])->toBe(['width' => 123, 'height' => 123]);
});

test('set scale', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->scale(.5);
    expect($data->toArray()['widgetData']['json']['scale']['scale'])->toBe(.5);
});

test('set relative scale', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->relativeScale(.5);
    expect($data->toArray()['widgetData']['json']['relativeScale'])->toBe(.5);
});

test('set rotation', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->rotation(.5);
    expect($data->toArray()['widgetData']['json']['rotation']['rotation'])->toBe(.5);
});

test('set relative rotation', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->relativeRotation(.5);
    expect($data->toArray()['widgetData']['json']['relativeRotation'])->toBe(.5);
});

test('set position', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->position(123, 123);
    expect($data->toArray()['widgetData']['json']['position'])->toBe(['x' => 123.0, 'y' => 123.0]);
});

test('set offset position', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->offsetPosition(123, 123);
    expect($data->toArray()['widgetData']['json']['_position']['offsetPx'])->toBe(['x' => 123.0, 'y' => 123.0]);
});

test('set background color style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->backgroundColor(16711680)->backgroundColor('#FF0000'));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['bc'])->toBe(16711680);
});

test('set background opacity style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->backgroundOpacity(.5));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['bo'])->toBe(.5);
});

test('set border color style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->borderColor(16711680)->borderColor('#FF0000'));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['brc'])->toBe(16711680);
});

test('set border thickness style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->borderThickness(5));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['brw'])->toBe(5);
});

test('set border opacity style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->borderOpacity(.5));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['bro'])->toBe(.5);
});

test('set border style style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->borderStyle(BorderStyle::DashLong));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['brs'])->toBe(BorderStyle::DashLong->value);
});

test('set font family style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->fontFamily('Arial'));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['ffn'])->toBe('Arial');
});

test('set text color style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->textColor(16711680)->textColor('#FF0000'));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['tc'])->toBe(16711680);
});

test('set text align style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->textAlign(TextAlign::Left, VerticalTextAlign::Top));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['ta'])->toBe(TextAlign::Left->value);
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['tav'])->toBe(VerticalTextAlign::Top->value);
});

test('set font size style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->fontSize(11));
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['fs'])->toBe(11);
});

test('set bold style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->bold());
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['b'])->toBe(1);
});

test('set italic style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->italic());
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['i'])->toBe(1);
});

test('set underline style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->underline());
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['u'])->toBe(1);
});

test('set strikethrough style', function() {
    $data = (new MiroShape(MiroShapeType::Square, 0, 'test'))->style(fn(MiroShapeStyle $style) => $style->strikethrough());
    expect(json_decode($data->toArray()['widgetData']['json']['style'], true)['s'])->toBe(1);
});
