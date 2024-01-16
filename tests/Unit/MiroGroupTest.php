<?php

use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;
use MiroClipboard\Objects\MiroGroup;
use MiroClipboard\Objects\MiroShape;

test('create group from array', function() {
    $clipboardData = MiroClipboardData::make()
        ->addGroup([
            $shape1 = MiroWidget::make()->shape()->text('hello')->position(100, 100),
            $shape2 = MiroWidget::make()->shape()->text('world')->position(200, 200),
        ]);

    expect($clipboardData->getObjects())->toHaveCount(3);

    expect($shape1->group())->toEqual($clipboardData->getObjects()[2]);
    expect($shape2->group())->toEqual($clipboardData->getObjects()[2]);
});

test('create group from object', function() {
    $group = MiroGroup::make()
        ->add($shape1 = MiroWidget::make()->shape()->text('test1')->position(100, 100))
        ->add($shape2 = MiroWidget::make()->shape()->text('test2')->position(200, 200));

    $clipboardData = MiroClipboardData::make()->addObject($group);

    expect($clipboardData->getObjects())->toHaveCount(3);
    expect(array_map(fn($x) => get_class($x), $clipboardData->getObjects()))->toBe([MiroShape::class, MiroShape::class, MiroGroup::class]);

    expect($shape1->group())->toEqual($group);
    expect($shape2->group())->toEqual($group);
});

test('can get group of object', function() {
    $group = MiroGroup::make()
        ->add($shape = MiroWidget::make()->shape()->text('test1')->position(100, 100));

    expect($shape->group())->toEqual($group);
});

test('group to array', function() {
    $group = MiroGroup::make()
        ->add(MiroWidget::make()->id(123)->shape()->text('test1')->position(100, 100))
        ->add(MiroWidget::make()->id(456)->shape()->text('test2')->position(200, 200))
        ->add(987);

    expect($group->toArray()['items'])->toBe([123, 456, 987]);
});

test('find object in group', function() {
    $group = MiroGroup::make();

    expect($group->findObject(123))->toBeFalse();

    $group->add(MiroWidget::make()->id(123)->shape()->text('test1')->position(100, 100));

    expect($group->findObject(123))->toBeInstanceOf(MiroShape::class);
});
