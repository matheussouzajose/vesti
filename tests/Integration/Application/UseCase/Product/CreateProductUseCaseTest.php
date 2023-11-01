<?php

namespace Tests\Integration\Application\UseCase\Product;

use Core\Application\Exceptions\MaxLimitProductsException;
use Core\Application\Exceptions\ServerErrorRequestHttpException;
use Core\Application\Exceptions\UnprocessableRequestHttpException;
use Core\Application\UseCase\Product\CreateProductUseCase;
use Core\Application\UseCase\Product\Dto\CreateProductInputDto;
use Core\Application\UseCase\Product\ListProductsUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Http\Exceptions\FileGetContentsException;
use Core\Infrastructure\Http\FileGetContents\FileGetContents;
use Core\Infrastructure\Http\Guzzle\GuzzleHttpIntegration;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    protected GuzzleHttpIntegration $guzzleHttpIntegration;
    protected string $companyId = 'company_id';
    protected string $token = 'token';

    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleHttpIntegration = new GuzzleHttpIntegration();
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws NotificationException
     * @throws MaxLimitProductsException|UnprocessableRequestHttpException
     * @throws FileGetContentsException
     */
    public function test_exception_when_products_is_greater_than_one_hundred()
    {
        $this->expectExceptionObject(MaxLimitProductsException::limit(100));

        $products = new ListProductsUseCase(fileGetContents: new FileGetContents());
        $data = ($products)();

        $input = new CreateProductInputDto(
            companyId: $this->companyId,
            token: $this->token,
            data: $data->result
        );

        $useCase = new CreateProductUseCase(httpIntegration: $this->guzzleHttpIntegration);

        ($useCase)(input: $input);
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws NotificationException
     * @throws MaxLimitProductsException|FileGetContentsException
     */
    public function test_exception_when_throws_unprocessable_request()
    {
        $this->expectException(UnprocessableRequestHttpException::class);

        $products = new ListProductsUseCase(fileGetContents: new FileGetContents());
        $data = ($products)();

        $input = new CreateProductInputDto(
            companyId: $this->companyId,
            token: $this->token,
            data: array_slice($data->result, 0, 100)
        );

        $useCase = new CreateProductUseCase(httpIntegration: $this->guzzleHttpIntegration);

        ($useCase)(input: $input);
    }
}