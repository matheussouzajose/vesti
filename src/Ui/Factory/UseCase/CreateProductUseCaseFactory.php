<?php

namespace Core\Ui\Factory\UseCase;

use Core\Application\UseCase\Product\CreateProductUseCase;
use Core\Infrastructure\Http\Guzzle\GuzzleHttpIntegration;

class CreateProductUseCaseFactory
{
    public static function create(): CreateProductUseCase
    {
        return new CreateProductUseCase(
            httpIntegration: new GuzzleHttpIntegration()
        );
    }
}