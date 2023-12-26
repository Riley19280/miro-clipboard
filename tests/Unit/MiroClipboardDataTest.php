<?php

use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;

test('set board id', function() {
    $data = MiroClipboardData::make()->boardId('testing');
    expect($data->toArray()['boardId'])->toBe('testing');

});

test('add object', function() {
    $data = MiroClipboardData::make()->addObject((new MiroWidget())->id(0)->initialId('0'));
    expect($data->toArray()['data']['objects'][0]['id'])->toBe(0);
    expect($data->toArray()['data']['objects'][0]['initialId'])->toBe('0');
});

test('add group', function() {
    $data = MiroClipboardData::make()->addGroup([
        (new MiroWidget())->id(0)->initialId('0'),
        (new MiroWidget())->id(1)->initialId('1'),
    ]);
    expect($data->toArray()['data']['objects'][0]['id'])->toBe(0);
    expect($data->toArray()['data']['objects'][1]['id'])->toBe(1);
});
