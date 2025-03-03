<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CheckController
{
    public function index(Request $request, Response $response): Response
    {
        
        $payload = json_encode([
            "code" => 201,
            "msg" => "system is runninng"
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $response->getBody()->write($payload);
        
        return $response
            ->withStatus(201);
    }
}