<?php
require_once __DIR__ . '/routes/web.php';

$request = $_SERVER['REQUEST_URI'];
$router = new Router();
$router->dispatch($request);
