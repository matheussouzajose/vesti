<?php

namespace Core\Application\Exceptions;

class MaxLimitProductsException extends \Exception
{
    public static function limit(int $limit): MaxLimitProductsException
    {
        $message = sprintf('Maximum limit of %s products', $limit);
        return new self(
            message: $message,
            code: 422
        );
    }
}