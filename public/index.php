<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

App\Core\Csrf::ensureSession();

$root = dirname(__DIR__, 2);
if (file_exists($root.'/.env')) {
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();
}

require_once("routes.php");

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
