<?php

namespace MiroClipboard\Exceptions;

use Throwable;

class ParserNotResolvedException extends MiroDataException
{
    public function __construct(string $parserType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Unable to resolve a parser for widget type '$parserType'", $code, $previous);
    }
}
