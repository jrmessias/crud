<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

App\Core\Csrf::ensureSession();

$root = dirname(__DIR__, 2);
if (file_exists($root.'/.env')) {
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();
}

require_once("routes.php");
