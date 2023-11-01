<?php

namespace Core\Application\UseCase\Product\Factory;

use Core\Domain\Product\ObjectValues\ProductVariation;

class CreateVariationsToRequestFactory
{
    /**
     * @return ProductVariation[]
     */
    public static function create(array $variations): array
    {
        return array_map(function ($variation) {
            return [
                'sku' => $variation->variation,
                'size' => $variation->size,
                'color' => $variation->color,
                'quantity' => $variation->quantity,
                'order' => $variation->order,
                'unit_type' => $variation->unity,
            ];
        }, $variations);
    }
}