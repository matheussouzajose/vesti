<?php

namespace Core\Application\UseCase\Product\Factory;

use Core\Domain\Product\Entity\Product;

class CreateProductsToRequestFactory
{
    /**
     * @return Product[]
     */
    public static function create(array $products): array
    {
        return array_map(function ($product) {
            return CreateProductToRequestFactory::create(product: $product);
        }, $products);
    }
}