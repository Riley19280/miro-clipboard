<?php

namespace MiroClipboard\Utility;

trait Makeable
{
    public static function make(): self
    {
        return new self;
    }
}
