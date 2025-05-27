<?php

require_once __DIR__ . '/../Model/Task.php';

class TaskService
{
    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task();
    }

    public function createTask($title, $description, $status, $userId)
    {
        if (empty($title) || empty($description) || empty($status) || empty($userId)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        if (!in_array($status, ['pendente', 'concluida'])) {
            throw new Exception("Status inválido. Use 'pendente' ou 'concluida'.");
        }

        return $this->taskModel->createTask($title, $description, $status, $userId);
    }

    public function getTask($id)
    {
        $task = $this->taskModel->getTask($id);
        if (!$task) {
            throw new Exception("Task não encontrada.");
        }
        return $task;
    }

    public function getAllTasks()
    {
        return $this->taskModel->getAllTasks();
    }

    public function updateTask($id, $title, $description)
    {
        $task = $this->taskModel->getTask($id);
        if (!$task) {
            throw new Exception("Task não encontrada para atualização.");
        }

        return $this->taskModel->updateTask($id, $title, $description);
    }

    public function deleteTask($id)
    {
        $task = $this->taskModel->getTask($id);
        if (!$task) {
            throw new Exception("Task não encontrada para exclusão.");
        }

        return $this->taskModel->deleteTask($id);
    }
}
