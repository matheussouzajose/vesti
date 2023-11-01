<?php

namespace Core\Ui\Api\Controllers;

use Core\Application\UseCase\Product\CreateProductUseCase;
use Core\Application\UseCase\Product\Dto\CreateProductInputDto;
use Core\Application\UseCase\Product\ListProductsUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateProductController
{
    public function __construct(
        protected CreateProductUseCase $createProductUseCase,
        protected ListProductsUseCase $listProductsUseCase
    ) {
    }

    /**
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $products = ($this->listProductsUseCase)();

            $input = new CreateProductInputDto(
                companyId: $args['companyId'],
                token: $request->getHeaderLine('ApiKey'),
                data: array_slice($products->result, 0, 100)
            );

            $data = ($this->createProductUseCase)(input: $input);

            $response->getBody()->write(
                $this->responseMessage(true, 'Created', 'Products registered successfully', $data->statusCode)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($data->statusCode);
        } catch (\Exception $exception) {
            $response->getBody()->write(
                $this->responseMessage(false, 'Error', $exception->getMessage(), $exception->getCode())
            );
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($exception->getCode());
        }
    }

    private function responseMessage($success, $message, $messages, $statusCode): bool|string
    {
        return json_encode([
            'result' => [
                'success' => $success,
                'message' => $message,
                'messages' => $messages,
            ],
            'statusCode' => $statusCode
        ]);
    }
}