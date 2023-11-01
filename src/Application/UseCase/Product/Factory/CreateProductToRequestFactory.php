<?php

namespace Core\Application\UseCase\Product\Factory;

use Core\Domain\Product\Entity\Product;

class CreateProductToRequestFactory
{
    public static function create(Product $product): array
    {
        return [
            'integration_id' => $product->reference,
            'name' => $product->name,
            'price' => $product->price,
            'price_promotion' => $product->promotion,
            'composition' => $product->composition,
            'brand' => $product->brand,
            'description' => $product->description ?? null,
            'variations' => CreateVariationsToRequestFactory::create(variations: $product->variations)
        ];
    }
}