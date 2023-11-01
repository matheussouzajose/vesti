<?php

namespace Tests\Integration\Application\UseCase\Product;

use Core\Application\UseCase\Product\ListProductsUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Http\Exceptions\FileGetContentsException;
use Core\Infrastructure\Http\FileGetContents\FileGetContents;
use PHPUnit\Framework\TestCase;

class ListProductsUseCaseTest extends TestCase
{
    /**
     * @throws NotificationException
     * @throws FileGetContentsException
     */
    public function test_list_products_with_variations()
    {
        $fileGetContent = new FileGetContents();
        $products = new ListProductsUseCase(fileGetContents: $fileGetContent);

        $result = ($products)();

        $this->assertIsArray($result->result);
        $this->assertEquals(200, $result->statusCode);
    }
    
}