<?php

use MiroClipboard\Enums\WidgetType;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroLine;
use MiroClipboard\Objects\MiroShape;

test('set type', function() {
    $data = (new MiroWidget(0, 'test'))->type(WidgetType::Sticker);
    expect(invade($data)->widgetType)->toBe(WidgetType::Sticker);
});

test('set shape', function() {
    $data = (new MiroWidget(0, 'test'))->shape();
    expect($data)->toBeInstanceOf(MiroShape::class);
});

test('set line', function() {
    $data = (new MiroWidget(0, 'test'))->line();
    expect($data)->toBeInstanceOf(MiroLine::class);
});
