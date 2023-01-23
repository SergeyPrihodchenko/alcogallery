<?php

use Alco\Market\Class\HTTP\Action\Authentication;
use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;

require_once './bootstrap.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $method = $request->method();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

try {
    $header = $request->header('ACTION');
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

$routes = [
    'POST' => [
        'AUTHENTICATION' => Authentication::class
    ]
];

if(!array_key_exists($method, $routes)) {
    (new ErrorResponse("Route not found: $method"))->send();
    return;
}

if(!array_key_exists($header, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $header"))->send();
}

$actionClassName = $routes[$method][$header];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();