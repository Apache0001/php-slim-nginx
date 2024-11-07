<?php
use App\Controllers\UserController;

return function ($app) {
    $app->get('/user', [UserController::class, 'index']);
    $app->post('/user/photo', [UserController::class, 'photo']);
};