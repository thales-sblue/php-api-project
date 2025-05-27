<?php

require_once __DIR__ . '/../Model/User.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function createUser($name, $email)
    {
        if (empty($name) || empty($email)) {
            throw new Exception("Os campos nome e email são obrigatórios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido.");
        }

        $users = $this->userModel->getAllUsers();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                throw new Exception("Já existe um usuário com este email.");
            }
        }

        return $this->userModel->createUser($name, $email);
    }

    public function getUser($id)
    {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            throw new Exception("Usuário não encontrado.");
        }
        return $user;
    }

    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function updateUser($id, $name, $email)
    {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            throw new Exception("Usuário não encontrado para atualização.");
        }

        if (empty($name) || empty($email)) {
            throw new Exception("Os campos nome e email são obrigatórios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido.");
        }

        return $this->userModel->updateUser($id, $name, $email);
    }

    public function deleteUser($id)
    {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            throw new Exception("Usuário não encontrado para exclusão.");
        }

        return $this->userModel->deleteUser($id);
    }
}
