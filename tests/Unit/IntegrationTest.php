<?php

use MiroClipboard\Enums\MiroWidgetType;
use MiroClipboard\MiroLine;
use MiroClipboard\MiroShape;
use MiroClipboard\MiroWidget;

test('set type', function() {
    $data = (new MiroWidget(0, 'test'))->type(MiroWidgetType::Sticker);
    expect(invade($data)->widgetType)->toBe(MiroWidgetType::Sticker);
});

test('set shape', function() {
    $data = (new MiroWidget(0, 'test'))->shape();
    expect($data)->toBeInstanceOf(MiroShape::class);
});

test('set line', function() {
    $data = (new MiroWidget(0, 'test'))->line();
    expect($data)->toBeInstanceOf(MiroLine::class);
});
