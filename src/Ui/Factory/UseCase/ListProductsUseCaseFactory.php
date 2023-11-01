<?php

namespace Core\Ui\Factory\UseCase;

use Core\Application\UseCase\Product\ListProductsUseCase;
use Core\Infrastructure\Http\FileGetContents\FileGetContents;

class ListProductsUseCaseFactory
{
    public static function create(): ListProductsUseCase
    {
        return new ListProductsUseCase(
            fileGetContents: new FileGetContents()
        );
    }
}