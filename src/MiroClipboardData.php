<?php

namespace MiroClipboard;

use MiroClipboard\Utility\Makeable;

use function MiroClipboard\Utility\stringToByteArray;

class MiroClipboardData
{
    use Makeable;

    private string $boardId;
    private string $host      = 'miro.com';
    private bool $isProtected = false;
    private int $version      = 2;

    private const encodingOffset = 59;

    private array $data = [
        'meta'    => [],
        'objects' => [],
    ];

    public function __construct()
    {
        $this->boardId = bin2hex(random_bytes(16));
    }

    public function boardId(string $id): static
    {
        $this->boardId = $id;

        return $this;
    }

    public function addObject(MiroObject $object): static
    {
        $this->data['objects'][] = $object->toArray();

        return $this;
    }

    /**
     * @param MiroObject[] $group
     *
     * @return $this
     */
    public function addGroup(array $group): static
    {
        foreach ($group as $groupItem) {
            $this->addObject($groupItem);
        }

        return $this;
    }

    public function encoded(): string
    {
        $json = json_encode($this->toArray());

        $newStr = '';

        foreach (stringToByteArray($json) as $chr) {
            $newStr .= chr($chr < 256 ? ($chr + self::encodingOffset) % 256 : $chr);
        }

        return base64_encode($newStr);
    }

    public static function fromString(string $text): array
    {
        $isHtml = preg_match('/(?:^.*?\(miro-data-v[0-9]+\))(.*?)(?:\(\/miro-data-v[0-9]+\).*?$)/', $text, $matches);
        if ($isHtml) {
            $text = $matches[1];
        }

        $text = base64_decode($text);

        $newStr = '';

        foreach (stringToByteArray($text) as $chr) {
            $newStr .= mb_chr($chr < self::encodingOffset ? 256 - $chr : $chr - self::encodingOffset);
        }

        return json_decode($newStr, true);
    }

    public function toArray(): array
    {
        return [
            'boardId'     => $this->boardId,
            'data'        => $this->data,
            'host'        => $this->host,
            'version'     => $this->version,
            'isProtected' => $this->isProtected,
        ];
    }

    public function toHTML(): string
    {
        return '<span data-meta="<--(miro-data-v1)' . $this->encoded() . '(/miro-data-v1)-->"></span>';
    }
}
