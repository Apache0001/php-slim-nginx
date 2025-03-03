<?php
require __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use App\Controllers\CheckController;
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
$routeAuth = require_once __DIR__.'/../routes/api/index.php';
$routeUser = require_once __DIR__.'/../routes/user/index.php';

/**
 * Register your routes here
 */
$routeAuth($app);
$routeUser($app);

/**
 * 
 * Add CORS Middleware
 * 
 */
$app->add(function (Request $request, RequestHandler $handler) {
  $response = $handler->handle($request);
  return $response
    ->withHeader('Content-Type', 'application/json')
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

/**
 * Error Middleware
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null $logger -> Optional PSR-3 Logger
 * @return ErrorMiddleware
 */
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
  Request $request,
  Throwable $exception,
  bool $displayErrorDetails,
  bool $logErrors,
  bool $logErrorDetails
) use ($app) {
  $response = $app->getResponseFactory()->createResponse();
  $response->getBody()->write(json_encode([
      "code" => 404,
      "message" => "endpoit not found!"
  ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

  return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
});

$app->run();