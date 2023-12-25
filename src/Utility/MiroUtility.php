<?php

namespace MiroClipboard\MiroUtility;

use function MiroClipboard\Utility\stringToByteArray;

function encodeMiroData(array $data, int $encodingOffset = 59): string
{
    $json = json_encode($data);

    $newStr = '';

    foreach (stringToByteArray($json) as $chr) {
        $newStr .= chr($chr < 256 ? ($chr + $encodingOffset) % 256 : $chr);
    }

    $base64 = base64_encode($newStr);

    return '<span data-meta="<--(miro-data-v1)' . $base64 . '(/miro-data-v1)-->"></span>';
}

function decodeMiroDataString(string $text, int $encodingOffset = 59): array
{
    $isHtml = preg_match('/(?:^.*?\(miro-data-v[0-9]+\))(.*?)(?:\(\/miro-data-v[0-9]+\).*?$)/', $text, $matches);
    if ($isHtml) {
        $text = $matches[1];
    }

    $text = base64_decode($text);

    $newStr = '';

    foreach (stringToByteArray($text) as $chr) {
        $newStr .= mb_chr($chr < $encodingOffset ? 256 - $chr : $chr - $encodingOffset);
    }

    return json_decode($newStr, true);
}
