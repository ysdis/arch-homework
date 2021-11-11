<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/health', function () {
    return response()->json(['status' => 'OK']);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
