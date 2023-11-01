<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Ui\Factory\Controller\CreateProductControllerFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response as SlimResponse;

$app = AppFactory::create();

$tokenValidationMiddleware = function (Request $request, RequestHandler $handler) use ($app) {
    $token = $request->getHeaderLine('ApiKey');

    if ( !$token ) {
        $response = new SlimResponse();
        $response->getBody()->write(
            json_encode(['message' => 'unauthorized'])
        );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);
    }

    return $handler->handle($request);
};

$app->add($tokenValidationMiddleware);

$app->post('/v1/api/products/{companyId}', function (Request $request, Response $response, $args) {
    $controller = CreateProductControllerFactory::create();
    return ($controller)($request, $response, $args);
});

$app->run();