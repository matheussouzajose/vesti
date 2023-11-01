<?php

namespace Core\Ui\Factory\Controller;

use Core\Ui\Api\Controllers\CreateProductController;
use Core\Ui\Factory\UseCase\CreateProductUseCaseFactory;
use Core\Ui\Factory\UseCase\ListProductsUseCaseFactory;

class CreateProductControllerFactory
{
    public static function create(): CreateProductController
    {
        return new CreateProductController(
            createProductUseCase: CreateProductUseCaseFactory::create(),
            listProductsUseCase: ListProductsUseCaseFactory::create()
        );
    }
}