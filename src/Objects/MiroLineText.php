<?php

namespace MiroClipboard\Objects;

use MiroClipboard\Utility\SetPropertiesFromArray;

class MiroLineText
{
    use SetPropertiesFromArray;

    private string $id;
    private string $text;

    private int $color = 1710618;

    private int $fontSize = 14;

    private array $position = [
        'x' => .5,
        'y' => .5,
    ];

    private bool $rotated = false;

    private int $width = 50;

    public static function make(string $text, float $x, float $y): self
    {
        return new self($text, $x, $y);
    }

    public function __construct(string $text, float $x, float $y)
    {
        assert($x >= 0, 'x position must be greater than or equal to 0');
        assert($x <= 1, 'x position must be less than or equal to 1');
        assert($y >= 0, 'y position must be greater than or equal to 0');
        assert($y <= 1, 'y position must be less than or equal to 1');

        $this->id   = bin2hex(random_bytes(16));
        $this->text = $text;

        $this->position = [
            'x' => $x,
            'y' => $y,
        ];
    }

    public function color(int|string $color): static
    {
        if (is_string($color)) {
            $this->color = hexdec(str_replace('#', '', $color));
        } else {
            $this->color = $color;
        }

        return $this;
    }

    public function fontSize(int $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function rotated(bool $rotated = true): static
    {
        $this->rotated = $rotated;

        return $this;
    }

    public function width(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'text'     => $this->text,
            'color'    => $this->color,
            'fontSize' => $this->fontSize,
            'position' => $this->position,
            'rotated'  => $this->rotated,
            'width'    => $this->width,
        ];
    }
}
