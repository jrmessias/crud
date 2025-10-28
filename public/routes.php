<?php

use App\Controllers\ProductController;
use App\Controllers\SiteController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routeCollector) {
    $routeCollector->addGroup('/', function (FastRoute\RouteCollector $site) {
        $site->addRoute('GET', '', [SiteController::class, 'index']);
    });

    $routeCollector->addGroup('/admin', function (FastRoute\RouteCollector $group) {
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