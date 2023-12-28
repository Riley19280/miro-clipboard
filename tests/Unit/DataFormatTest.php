<?php

use MiroClipboard\MiroClipboardData;
use MiroClipboard\MiroWidget;
use MiroClipboard\Styles\MiroShapeStyle;

use function MiroClipboard\MiroUtility\decodeMiroDataString;

test('encoding', function() {
    $clipboardData = MiroClipboardData::make()
        ->boardId('encoding')
        ->addObject(MiroWidget::make()
            ->id(0)
            ->initialId('0')
            ->shape()
            ->style(fn(MiroShapeStyle $style) => $style->backgroundColor('#FF0000'))
        );

    expect($clipboardData->toHTML())->toMatchSnapshot();
});

test('decoding', function() {
    $data = 'tl2kroutqq+gnq+gn111oZynrqBnXZ2qnK2fhJ9ddV2voK6vpKmiXWddn5yvnF11tl2qnaWgnq+uXXWWtl2ypJ+ioK9/nK+cXXW2XaWuqqlddbZdq6qkqa+uXXWWmGddq62kqJyttF11tl2rqqSpr111tl2zXXVscXNnXbRddWhxcmlya25ucHJrdGxtbHS4Z12rqq6kr6SqqY+0q6BddWtnXbKkn6Kgr4Spn6CzXXVobLhnXa6gnqqpn5yttF11tl2rqqSpr111tl2zXXVobHFzZ120XXVxcmlya25ucHJrdGxtbHR0bLhnXauqrqSvpKqpj7SroF11a2ddsqSfoqCvhKmfoLNddWhsuGddmquqrqSvpKqpXXWpsKenZ12aq5ytoKmvXXWpsKenZ12ur7SnoF11XbaXXaeel111bm5wcG9vbmeXXaeul111bWeXXa+XXXVtZ5ddp6+XXXVsZ5ddnJqur5ytr5dddWtnl12cmqCpn5dddXRnl12RgI2XXXVtZ5ddpbCoq5dddWu4XWddp6SpoF11tl2enKuvpKqprl11lpi4uGddr7SroF11XaekqaBduGddr7SroF11bG9nXaSfXXVrZ12kqaSvpJynhJ9ddV1sbW5duJhnXa6jpKGvXXW2XbNddXNrc2lwb2xwbHNtc21ybHFvZ120XXVtb21yaW10b2tycGxubnRwbWddr6qmoKmktaCthJ9/oJ5ddV1sbW5duGddqKCvnF11tri4Z12xoK2upKqpXXVtZ12jqq6vXXVdqKStqmmeqqhduA==';
    $res  = decodeMiroDataString('<span data-meta="<--(miro-data-v1)' . $data . '(/miro-data-v1)-->"></span>');

    expect($res)->toMatchSnapshot();
});
