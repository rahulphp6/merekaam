<?php
include_once "../core/config.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$table = $data['table'] ?? '';
$action = $data['action'] ?? '';

if ($action === 'filter' && $table === 'tasks') {
    $res = secureDbAction('tasks', 4, ['columns' => '*']);
    echo json_encode($res);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);
