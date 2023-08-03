<?php

require './config.php';
use JetBrains\PhpStorm\NoReturn;

chdir(__DIR__);

#[NoReturn] function redirectTo($path): void
{
    header('Location: ' . $path);
    exit();
}

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
match ($requestUri) {
    '/'         => redirectTo('/views/index'),
    '/products' => redirectTo('/views/products'),
    '/sales'    => redirectTo('/views/sales'),
    '/register' => redirectTo('/views/register'),
    default     => "Página não encontrada",
};
