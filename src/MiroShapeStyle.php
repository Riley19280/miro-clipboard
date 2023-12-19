<?php

namespace MiroClipboard;

use MiroClipboard\Enums\BorderStyle;
use MiroClipboard\Enums\TextAlign;
use MiroClipboard\Enums\VerticalTextAlign;
use MiroClipboard\Utility\Makeable;

class MiroShapeStyle
{
    use Makeable;

    private $st = 3;
    private $ss = 2;
    private $sc = 1710618;

    /**
     * The Background Color
     *
     * @var int
     */
    private int $bc = -1;

    /**
     * The Background Opacity
     *
     * @var float
     */
    private float $bo = 1;

    /**
     * The Border Color
     *
     * @var int
     */
    private int $brc = 15132390; // Black: 15132390

    /**
     * The Border Thickness
     *
     * @var int
     */
    private int $brw = 2;

    /**
     * The Border Opacity
     *
     * @var float
     */
    private float $bro = 1;

    /**
     * The Border Style
     *
     * @var int
     */
    private int $brs = 2;

    /**
     * The Font Family
     *
     * @var string
     */
    private string $ffn = 'OpenSans';

    /**
     * The Text Color
     *
     * @var int
     */
    private int $tc = 15877926;

    private $tsc = 1;

    /**
     * The Text Align
     * Values: l, c, r
     *
     * @var string
     */
    private string $ta = 'c';

    /**
     * The Vertical Text Align
     * Values: t, m, b
     *
     * @var string
     */
    private string $tav = 'm';

    /**
     * The Font Size
     *
     * @var int
     */
    private int $fs = 24;

    /**
     * Indicates if the text is bold
     *
     * @var null|int
     */
    private ?int $b = null;

    /**
     * Indicates if the text is italic
     *
     * @var null|int
     */
    private ?int $i = null;

    /**
     * Indicates if the text is underlined
     *
     * @var null|int
     */
    private ?int $u = null;

    /**
     * Indicates if the text is strikethrough
     *
     * @var null|int
     */
    private ?int $s = null;

    private $bsc = 1;
    private $VER = 2.1;

    /**
     * The text highlight color
     * Values: Hex colors
     *
     * @var null
     */
    private $hl = null;

    public function backgroundColor(int|string $color): static
    {
        if (is_string($color)) {
            $this->bc = hexdec($color);
        } else {
            $this->bc = $color;
        }

        return $this;
    }

    public function backgroundOpacity(float $opacity): static
    {
        $this->bo = $opacity;

        return $this;
    }

    public function borderColor(int|string $color): static
    {
        if (is_string($color)) {
            $this->brc = hexdec($color);
        } else {
            $this->brc = $color;
        }

        return $this;
    }

    public function borderThickness(int $thickness): static
    {
        $this->brw = $thickness;

        return $this;
    }

    public function borderOpacity(float $opacity): static
    {
        $this->bro = $opacity;

        return $this;
    }

    public function borderStyle(BorderStyle $style): static
    {
        $this->brs = $style->value;

        return $this;
    }

    public function fontFamily(string $fontFamily): static
    {
        $this->ffn = $fontFamily;

        return $this;
    }

    public function textColor(int|string $color): static
    {
        if (is_string($color)) {
            $this->tc = hexdec($color);
        } else {
            $this->tc = $color;
        }

        return $this;
    }

    public function textAlign(?TextAlign $horizontal = null, ?VerticalTextAlign $vertical = null): static
    {
        if ($horizontal) {
            $this->ta = $horizontal->value;
        }

        if ($vertical) {
            $this->tav = $vertical->value;
        }

        return $this;
    }

    public function fontSize(int $fontSize): static
    {
        $this->fs = $fontSize;

        return $this;
    }

    public function bold(bool $enabled = true): static
    {
        $this->b = (int)$enabled;

        return $this;
    }

    public function italic(bool $enabled = true): static
    {
        $this->i = (int)$enabled;

        return $this;
    }

    public function underline(bool $enabled = true): static
    {
        $this->u = (int)$enabled;

        return $this;
    }

    public function strikethrough(bool $enabled = true): static
    {
        $this->s = (int)$enabled;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'st'  => $this->st,
            'ss'  => $this->ss,
            'sc'  => $this->sc,
            'bc'  => $this->bc,
            'bo'  => $this->bo,
            'brc' => $this->brc,
            'brw' => $this->brw,
            'bro' => $this->bro,
            'brs' => $this->brs,
            'ffn' => $this->ffn,
            'tc'  => $this->tc,
            'tsc' => $this->tsc,
            'ta'  => $this->ta,
            'tav' => $this->tav,
            'fs'  => $this->fs,
            'b'   => $this->b,
            'i'   => $this->i,
            'u'   => $this->u,
            's'   => $this->s,
            'bsc' => $this->bsc,
            'VER' => $this->VER,
            'hl'  => $this->hl,
        ];
    }
}
