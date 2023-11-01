<?php

namespace Tests\Unit\Application\UseCase;

use Core\Application\Interfaces\HttpIntegrationInterface;
use Core\Application\UseCase\Product\CreateProductUseCase;
use Core\Application\UseCase\Product\Dto\CreateProductInputDto;
use Core\Application\UseCase\Product\Dto\ProductOutputDto;
use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\ObjectValues\ProductVariation;
use Core\Domain\Shared\Exception\NotificationException;
use PHPUnit\Framework\TestCase;

class ProductUseCaseUnitTest extends TestCase
{
    protected string $endpoint = "/v1/products/company";

    /**
     * @throws \Exception
     */
    public function test_new_product_success()
    {
        $httpIntegration = \Mockery::spy(\stdClass::class, HttpIntegrationInterface::class);
        $httpIntegration->shouldReceive('post')->andReturn($this->mockResponse());

        $productUseCase = new CreateProductUseCase(httpIntegration: $httpIntegration);

        $input = new CreateProductInputDto(
            companyId: 'company_id',
            token: 'token_id',
            data: $this->mockProducts()
        );

        $response = ($productUseCase)(input: $input);

        $this->assertInstanceOf(ProductOutputDto::class, $response);
        $this->assertEquals([
            'success' => true,
            'message' => "Ok",
            'messages' => "",
        ], $response->result);
        $this->assertEquals(200, $response->statusCode);
    }

    /**
     * @throws NotificationException
     */
    private function mockProducts(): array
    {
        $product = new Product(
            reference: '1761095',
            name: 'SHORT ANTI FIT',
            price: '109,90',
            promotion: '66',
            composition: '100% Algodão',
            brand: 'Joana Modas',
        );

        $product->addVariation(
            new ProductVariation(
                variation: '1761196_48_CLARA',
                size: '48',
                color: 'CLARA',
                quantity: 0,
                unity: 'UN',
                order: 7
            )
        );

        return [$product];
    }

    private function mockResponse(): array
    {
        return [
            'result' => [
                'success' => true,
                'message' => "Ok",
                'messages' => "",
            ],
            'statusCode' => 200
        ];
    }

    public function tearDown(): void
    {
        \Mockery::close();
    }
}