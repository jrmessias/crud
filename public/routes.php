<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\ProductController;
use App\Controllers\SiteController;
use Symfony\Component\HttpFoundation\Request;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routeCollector) {
    $routeCollector->addGroup('/', function (FastRoute\RouteCollector $site) {
        $site->addRoute('GET', '', [SiteController::class, 'index']);
    });

    $routeCollector->addGroup('/admin', function (FastRoute\RouteCollector $group) {
        $group->addGroup('', function (FastRoute\RouteCollector $admin) {
            $admin->addRoute('GET', '', [AdminController::class, 'index']);
        });

        // Autenticação
        $group->addGroup('/auth', function (FastRoute\RouteCollector $auth) {
            $auth->addRoute('GET', '/login', [AuthController::class, 'login']);
            $auth->addRoute('POST', '/authenticate', [AuthController::class, 'authenticate']);
            $auth->addRoute('POST', '/logout', [AuthController::class, 'logout']);
        });

        // Produtos
        $group->addGroup('/products', function (FastRoute\RouteCollector $products) {
            $products->addRoute('GET', '', [ProductController::class, 'index']);
            $products->addRoute('GET', '/create', [ProductController::class, 'create']);
            $products->addRoute('POST', '/store', [ProductController::class, 'store']);
            $products->addRoute('GET', '/show', [ProductController::class, 'show']);
            $products->addRoute('GET', '/edit', [ProductController::class, 'edit']);
            $products->addRoute('POST', '/update', [ProductController::class, 'update']);
            $products->addRoute('POST', '/delete', [ProductController::class, 'delete']);
        });
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) $uri = substr($uri, 0, $pos);
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
$request = Request::createFromGlobals();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404); echo '404'; break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405); echo '405'; break;
    case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $controller = new $class();
        $response = $controller->$method($request);
        $response->send();
        break;
}