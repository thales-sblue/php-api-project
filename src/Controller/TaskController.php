<?php

require_once __DIR__ . '/../Model/Task.php';

class TaskController
{
    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task();
    }

    public function handleRequest($method, $uri)
    {
        $id = isset($uri[2]) ? (int)$uri[2] : null;

        switch ($method) {
            case 'GET':
                if ($id) {
                    $task = $this->taskModel->getTask($id);
                    if ($task) {
                        echo json_encode($task, JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Task not found'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    $tasks = $this->taskModel->getAllTasks();
                    echo json_encode($tasks, JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['title'], $data['description'], $data['user_id'])) {
                    $created = $this->taskModel->createTask($data['title'], $data['description'], $data['user_id']);
                    if ($created) {
                        http_response_code(201);
                        echo json_encode(['message' => 'Task created successfully'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to create task'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input'], JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'PUT':
                if ($id) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['title'], $data['description'])) {
                        $updated = $this->taskModel->updateTask($id, $data['title'], $data['description']);
                        if ($updated) {
                            echo json_encode(['message' => 'Task updated successfully'], JSON_UNESCAPED_UNICODE);
                        } else {
                            http_response_code(500);
                            echo json_encode(['error' => 'Failed to update task'], JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Invalid input'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Task ID is required for update'], JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'DELETE':
                if ($id) {
                    $deleted = $this->taskModel->deleteTask($id);
                    if ($deleted) {
                        echo json_encode(['message' => 'Task deleted successfully'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to delete task'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Task ID is required for deletion'], JSON_UNESCAPED_UNICODE);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
                break;
        }
    }
}
