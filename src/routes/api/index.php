<?php
use App\Controllers\AuthController;
use App\Controllers\CheckController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\AdminMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (&$app) {
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->get('/check', [ CheckController::class, 'index' ]);
    });
};