<?php
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\AdminMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (&$app) {
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->post('/user', [ UserController::class, 'insert' ]);
        $group->get('/user/{id}', [ UserController::class, 'show' ]);
        $group->get('/user', [ UserController::class, 'index' ]);
        $group->put('/user/{id}', [ UserController::class, 'update' ]);
        $group->delete('/user/{id}', [ UserController::class, 'delete' ]);
        $group->post('/user/photo', [ UserController::class, 'photo' ]);
    })->add(new AdminMiddleware())->add(new AuthMiddleware());
};