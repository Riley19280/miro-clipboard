<?php

namespace MiroClipboard\Styles;

use MiroClipboard\Enums\LineCap;
use MiroClipboard\Enums\LinePattern;
use MiroClipboard\Enums\LineType;
use MiroClipboard\Utility\SetPropertiesFromArray;

class MiroLineStyle
{
    use SetPropertiesFromArray;

    /**
     * The Line Color
     *
     * @var int
     */
    private int $lc = 1710618;

    /**
     * The Line Pattern
     *
     * @var int
     */
    private int $ls = 2;

    /**
     * The line stroke weight
     *
     * @var int
     */
    private int $t = 2;

    private int $lt = 2;

    /**
     * The starting line cap
     *
     * @var int
     */
    private int $a_start = 0;

    /**
     * The ending line cap
     *
     * @var int
     */
    private int $a_end = 0;

    /**
     * Indicates if the line "jumps" over other lines
     *
     * @var int
     */
    private int $jump = 0;

    private string $VER = '2';

    public function color(int|string $color): static
    {
        if (is_string($color)) {
            $this->lc = hexdec($color);
        } else {
            $this->lc = $color;
        }

        return $this;
    }

    public function strokeWeight(int $strokeWeight): static
    {
        $this->t = $strokeWeight;

        return $this;
    }

    public function startingLinecap(LineCap $lineCap): static
    {
        $this->a_start = $lineCap->value;

        return $this;
    }

    public function endingLinecap(LineCap $lineCap): static
    {
        $this->a_end = $lineCap->value;

        return $this;
    }

    public function jump(bool $jump = true): static
    {
        $this->jump = (int)$jump;

        return $this;
    }

    public function type(LineType $lineType): static
    {
        $this->lt = $lineType->value;

        return $this;
    }

    public function pattern(LinePattern $linePattern): static
    {
        $this->ls = $linePattern->value;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'lc'      => $this->lc,
            'ls'      => $this->ls,
            't'       => $this->t,
            'lt'      => $this->lt,
            'a_start' => $this->a_start,
            'a_end'   => $this->a_end,
            'VER'     => $this->VER,
            'jump'    => $this->jump,
        ];
    }
}
