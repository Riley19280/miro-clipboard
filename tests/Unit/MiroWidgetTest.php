<?php

use MiroClipboard\Enums\WidgetType;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLine;
use MiroClipboard\Objects\MiroShape;

test('set type', function() {
    $data = MiroWidget::make()->type(WidgetType::Sticker);
    expect(invade($data)->widgetType)->toBe(WidgetType::Sticker);
});

test('set shape', function() {
    $data = MiroWidget::make()->shape();
    expect($data)->toBeInstanceOf(MiroShape::class);
});

test('set line', function() {
    $data = MiroWidget::make()->line();
    expect($data)->toBeInstanceOf(MiroLine::class);
});

test('get id', function() {
    $data = MiroWidget::make()->id(1)->shape();

    expect($data->getId())->toBe(1);
});

test('get initial id', function() {
    $data = MiroWidget::make()->initialId(1)->shape();

    expect($data->getInitialId())->toBe('1');
});
