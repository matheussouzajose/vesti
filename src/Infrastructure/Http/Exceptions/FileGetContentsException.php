<?php

namespace Core\Infrastructure\Http\Exceptions;

use Core\Infrastructure\Http\FileGetContents\FileGetContents;

class FileGetContentsException extends \Exception
{
    public static function unableToRead(string $url): FileGetContentsException
    {
        $message = sprintf('Unable to read JSON file %s', $url);
        return new self(
            message: $message,
            code: 422
        );
    }

    public static function failedToDecode(): FileGetContentsException
    {
        return new self(
            message: 'Failed to decode JSON',
            code: 422
        );
    }

    public static function error(string $message): FileGetContentsException
    {
        $message = sprintf('An error occurred %s', $message);
        return new self(
            message: $message,
            code: 422
        );
    }
}