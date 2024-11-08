<?php
require_once __DIR__.'/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;

function responseJson(
    int $code,
    array $data,
    $response
) {
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
}