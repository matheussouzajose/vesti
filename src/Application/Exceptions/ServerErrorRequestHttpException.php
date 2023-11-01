<?php

namespace Core\Application\Exceptions;

class ServerErrorRequestHttpException extends \Exception
{
    public static function message(): ServerErrorRequestHttpException
    {
        return new self(
            message: 'An error occurred on the server',
            code: 500
        );
    }
}