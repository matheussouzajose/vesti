<?php

namespace Core\Domain\Product\Factory;

use Core\Domain\Product\Validator\ProductVariationValidator;
use Core\Domain\Shared\Validation\ValidatorInterface;

class ProductVariationValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new ProductVariationValidator();
    }
}