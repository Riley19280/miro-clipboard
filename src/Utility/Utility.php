<?php

namespace MiroClipboard\Utility;

function stringToByteArray(string $string): array
{
    return array_slice(unpack('C*', "\0" . $string), 1);
}
