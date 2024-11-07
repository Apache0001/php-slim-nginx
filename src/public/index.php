<?php
require __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

/**
  * The routing middleware should be added earlier than the ErrorMiddleware
  * Otherwise exceptions thrown from it will not be handled by the middleware
  */
  $app->addRoutingMiddleware();

  /**
   * Add Error Middleware
   *
   * @param bool                  $displayErrorDetails -> Should be set to false in production
   * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
   * @param bool                  $logErrorDetails -> Display error details in error log
   * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
   *
   * Note: This middleware should be added last. It will not handle any exceptions/errors
   * for middleware added after it.
   */
  $errorMiddleware = $app->addErrorMiddleware(true, true, true);

/**
 * Import your files route here
 */
$routeAuth = require_once __DIR__.'/../routes/auth/api.php';
$routeUser = require_once __DIR__.'/../routes/user/api.php';

/**
 * Register your routes here
 */
$routeAuth($app);
$routeUser($app);

$app->get('/foo', function (Request $request, Response $response, array $args) {
    $data = array('name' => 'Rob', 'age' => 40);
    $payload = json_encode($data);

    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(422);
});

$app->run();