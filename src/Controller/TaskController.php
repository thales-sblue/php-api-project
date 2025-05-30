<?php

require_once __DIR__ . '/../Service/TaskService.php';

class TaskController
{
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function handleRequest($method, $uri)
    {
        $id = isset($uri[2]) ? (int)$uri[2] : null;

        try {
            switch ($method) {
                case 'GET':
                    if ($id) {
                        $task = $this->taskService->getTask($id);
                        echo json_encode($task, JSON_UNESCAPED_UNICODE);
                    } else {
                        $tasks = $this->taskService->getAllTasks();
                        echo json_encode($tasks, JSON_UNESCAPED_UNICODE);
                    }
                    break;

                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->taskService->createTask(
                        $data['title'],
                        $data['description'],
                        $data['status'],
                        $data['user_id']
                    );
                    http_response_code(201);
                    echo json_encode(['message' => 'Task criada com sucesso!'], JSON_UNESCAPED_UNICODE);
                    break;

                case 'PUT':
                    if ($id) {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $this->taskService->updateTask(
                            $id,
                            $data['title'],
                            $data['description']
                        );
                        echo json_encode(['message' => 'Task atualizada com sucesso!'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'ID da task é obrigatório para atualizar'], JSON_UNESCAPED_UNICODE);
                    }
                    break;

                case 'DELETE':
                    if ($id) {
                        $this->taskService->deleteTask($id);
                        echo json_encode(['message' => 'Task deletada com sucesso'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'ID da task é obrigatório para deletar'], JSON_UNESCAPED_UNICODE);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Método não permitido'], JSON_UNESCAPED_UNICODE);
                    break;
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }
}
