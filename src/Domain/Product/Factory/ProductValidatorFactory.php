<?php

namespace Core\Domain\Product\Factory;

use Core\Domain\Product\Validator\ProductValidator;
use Core\Domain\Shared\Validation\ValidatorInterface;

class ProductValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new ProductValidator();
    }
}