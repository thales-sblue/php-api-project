<?php

require_once __DIR__ . '/../Database/Database.php';

class Task
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function createTask($title, $description, $status, $userId)
    {
        $query = "INSERT INTO tasks (title, description, status, user_id) VALUES (:title, :description, :status, :user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindValue(':status', $status = 'pendente');
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function getTask($id)
    {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllTasks()
    {
        $query = "SELECT * FROM tasks";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description)
    {
        $query = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function deleteTask($id)
    {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
