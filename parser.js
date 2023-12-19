let json = {
    'isProtected': false,
    'boardId': 'testing',
    'data': {
        'objects': [
            {
                'widgetData': {
                    'json': {
                        'points': [],
                        'primary': {
                            'point': { 'x': 168, 'y': -67.703357091219 },
                            'positionType': 0,
                            'widgetIndex': -1,
                        },
                        'secondary': {
                            'point': { 'x': -168, 'y': 67.70335709121991 },
                            'positionType': 0,
                            'widgetIndex': -1,
                        },
                        '_position': null,
                        '_parent': null,
                        'style': '{"lc":3355443,"ls":2,"t":2,"lt":1,"a_start":0,"a_end":9,"VER":2,"jump":0}',
                        'line': { 'captions': [] },
                    }, 'type': 'line',
                }, 'type': 14, 'id': 0, 'initialId': '123',
            }],
        'shift': { 'x': 808.5415182827164, 'y': 2427.294075133952, 'tokenizerIdDec': '123' },
        'meta': {},
    },
    'version': 2,
    'host': 'miro.com',
}

let clipboardData = 'tl2kroutqq+gnq+gn111oZynrqBnXZ2qnK2fhJ9ddV2voK6vpKmiXWddn5yvnF11tl2qnaWgnq+uXXWWtl2ypJ+ioK9/nK+cXXW2XaWuqqlddbZdq6qkqa+uXXWWmGddq62kqJyttF11tl2rqqSpr111tl2zXXVscXNnXbRddWhxcmlya25ucHJrdGxtbHS4Z12rqq6kr6SqqY+0q6BddWtnXbKkn6Kgr4Spn6CzXXVobLhnXa6gnqqpn5yttF11tl2rqqSpr111tl2zXXVobHFzZ120XXVxcmlya25ucHJrdGxtbHR0bLhnXauqrqSvpKqpj7SroF11a2ddsqSfoqCvhKmfoLNddWhsuGddmquqrqSvpKqpXXWpsKenZ12aq5ytoKmvXXWpsKenZ12ur7SnoF11XbaXXaeel111bm5wcG9vbmeXXaeul111bWeXXa+XXXVtZ5ddp6+XXXVsZ5ddnJqur5ytr5dddWtnl12cmqCpn5dddXRnl12RgI2XXXVtZ5ddpbCoq5dddWu4XWddp6SpoF11tl2enKuvpKqprl11lpi4uGddr7SroF11XaekqaBduGddr7SroF11bG9nXaSfXXVrZ12kqaSvpJynhJ9ddV1sbW5duJhnXa6jpKGvXXW2XbNddXNrc2lwb2xwbHNtc21ybHFvZ120XXVtb21yaW10b2tycGxubnRwbWddr6qmoKmktaCthJ9/oJ5ddV1sbW5duGddqKCvnF11tri4Z12xoK2upKqpXXVtZ12jqq6vXXVdqKStqmmeqqhduA=='

var enc = new TextEncoder()
var dec = new TextDecoder('utf8')

// This is a number defined by Miro, that is used to offset the character encoding by.
const OFFSET = 59

const miroEncode = (dataArray) => {
    return dataArray
    .map(x => x < 256 ? (x + OFFSET) % 256 : x)
    .reduce((a, x) => a + String.fromCharCode(x), '')
}

console.log(btoa(miroEncode(enc.encode(JSON.stringify(json)))) === clipboardData)

// Decoding
let arr = atob(clipboardData).split('').reduce((a, x) => {
    a.push(x.charCodeAt(0) < OFFSET ? 256 - x.charCodeAt(0) : x.charCodeAt(0) - OFFSET)
    return a
}, [])


const decoded = JSON.parse(dec.decode(Uint8Array.from(arr)))
console.log(JSON.stringify(decoded) === JSON.stringify(json))
