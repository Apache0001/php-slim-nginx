<?php
use App\Controllers\AuthController;

return function ($app) {
    $app->post('/auth', [AuthController::class, 'index']);
};