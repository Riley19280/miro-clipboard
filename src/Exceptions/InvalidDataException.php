<?php

namespace MiroClipboard\Exceptions;

use Throwable;

class InvalidDataException extends MiroDataException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Unable to parse miro clipboard data', $code, $previous);
    }
}
