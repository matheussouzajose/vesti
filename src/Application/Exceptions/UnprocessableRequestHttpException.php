<?php

namespace Core\Application\Exceptions;

class UnprocessableRequestHttpException extends \Exception
{
    public static function message(string $message, int $code): UnprocessableRequestHttpException
    {
        return new self(
            message: $message,
            code: $code
        );
    }
}