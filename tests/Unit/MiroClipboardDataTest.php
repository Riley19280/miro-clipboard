<?php

use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;

test('set board id', function() {
    $data = MiroClipboardData::make()->boardId('testing');
    expect($data->toArray()['boardId'])->toBe('testing');

});

test('add object', function() {
    $data = MiroClipboardData::make()->addObject(new MiroWidget(0, 'initialId'));
    expect($data->toArray()['data']['objects'][0]['id'])->toBe(0);
    expect($data->toArray()['data']['objects'][0]['initialId'])->toBe('initialId');
});

test('add group', function() {
    $data = MiroClipboardData::make()->addGroup([
        new MiroWidget(0, 'initialId'),
        new MiroWidget(1, 'initialId'),
    ]);
    expect($data->toArray()['data']['objects'][0]['id'])->toBe(0);
    expect($data->toArray()['data']['objects'][1]['id'])->toBe(1);
});
