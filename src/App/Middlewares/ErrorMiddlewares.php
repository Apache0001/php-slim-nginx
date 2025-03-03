<?php
namespace App\Middlewares;
use Slim\Middleware\ErrorMiddleware;
use Slim\Exception\HttpNotFoundException;

class ErrorMiddlewares
{
    public static function execute(&$app)
    {
        $response = $app->getResponseFactory()->createResponse();
        $response->getBody()->write(json_encode([
            "error" => true,
            "message" => "Rota não encontrada!"
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
      
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

}