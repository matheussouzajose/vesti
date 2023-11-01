<?php

namespace Core\Application\UseCase\Product;

use Core\Application\Exceptions\MaxLimitProductsException;
use Core\Application\Exceptions\ServerErrorRequestHttpException;
use Core\Application\Exceptions\UnprocessableRequestHttpException;
use Core\Application\Interfaces\HttpIntegrationInterface;
use Core\Application\UseCase\Product\Dto\CreateProductInputDto;
use Core\Application\UseCase\Product\Dto\ProductOutputDto;
use Core\Application\UseCase\Product\Factory\CreateProductsToRequestFactory;

class CreateProductUseCase
{
    protected string $endpoint = "/v1/products/company";

    public function __construct(protected HttpIntegrationInterface $httpIntegration)
    {
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws MaxLimitProductsException
     * @throws UnprocessableRequestHttpException
     */
    public function __invoke(CreateProductInputDto $input): ProductOutputDto
    {
        $this->validateMaxLimitProducts(limit: 100, data: $input->data);

        try {
            $data = CreateProductsToRequestFactory::create(products: $input->data);
            $url = "{$this->endpoint}/{$input->companyId}";

            $response = $this->httpIntegration->post(
                $url,
                $data,
                $this->setTokenHeader(token: $input->token)
            );

            return $this->output(
                result: $response['result'],
                statusCode: $response['statusCode']
            );
        } catch (\Exception $exception) {
            $this->validateRequestHttpError($exception);
        }
    }

    /**
     * @throws MaxLimitProductsException
     */
    private function validateMaxLimitProducts(int $limit, array $data): void
    {
        if ( $limit < count($data) ) {
            throw MaxLimitProductsException::limit($limit);
        }
    }

    private function setTokenHeader(string $token): array
    {
        return [
            'headers' => [
                'apikey' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ];
    }

    /**
     * @throws ServerErrorRequestHttpException
     * @throws UnprocessableRequestHttpException
     */
    private function validateRequestHttpError(\Exception $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();
        if ( $exception->hasResponse() && $statusCode > 400 || $statusCode || 499 ) {
            $body = json_decode($exception->getResponse()->getBody());
            throw UnprocessableRequestHttpException::message($body->message, $statusCode);
        }
        throw ServerErrorRequestHttpException::message();
    }

    private function output(array $result, int $statusCode): ProductOutputDto
    {
        return new ProductOutputDto(
            result: $result,
            statusCode: $statusCode
        );
    }
}