<?php

namespace MiroClipboard\Utility;

trait Makeable
{
    public static function make(): static
    {
        return new static;
    }
}
