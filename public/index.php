<?php
require_once __DIR__ . '/../src/Database/Database.php';

header('Content-Type: application/json');

echo json_encode([
    'message' => 'API esta rodando!'
]);
