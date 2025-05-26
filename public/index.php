<?php
require_once __DIR__ . '/../src/Database/Database.php';
require_once __DIR__ . '/../src/Controller/UserController.php';
require_once __DIR__ . '/../src/Controller/TaskController.php';

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$route = $uri[1] ?? '';

switch ($route) {
    case 'users':
        $controller = new UserController();
        $controller->handleRequest($_SERVER['REQUEST_METHOD'], $uri);
        break;

    case 'tasks':
        $controller = new TaskController();
        $controller->handleRequest($_SERVER['REQUEST_METHOD'], $uri);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
}
