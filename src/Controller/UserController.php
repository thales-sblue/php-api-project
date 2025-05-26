<?php
require_once __DIR__ . '/../Model/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function handlerequest($method, $uri)
    {

        $id = isset($uri[2]) ? (int)$uri[2] : null;

        switch ($method) {
            case 'GET':
                if ($id) {
                    $user = $this->userModel->getUser($id);
                    if ($user) {
                        echo json_encode($user, JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'User not found'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    $users = $this->userModel->getAllUsers();
                    echo json_encode($users, JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['name'], $data['email'])) {
                    $created = $this->userModel->createUser($data['name'], $data['email']);
                    if ($created) {
                        http_response_code(201);
                        echo json_encode(['message' => 'User created successfully'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to create user'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input'], JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'PUT':
                if ($id) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['name'], $data['email'])) {
                        $updated = $this->userModel->updateUser($id, $data['name'], $data['email']);
                        if ($updated) {
                            echo json_encode(['message' => 'User updated successfully'], JSON_UNESCAPED_UNICODE);
                        } else {
                            http_response_code(500);
                            echo json_encode(['error' => 'Failed to update user'], JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Invalid input'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'User ID is required for update'], JSON_UNESCAPED_UNICODE);
                }
                break;

            case 'DELETE':
                if ($id) {
                    $deleted = $this->userModel->deleteUser($id);
                    if ($deleted) {
                        echo json_encode(['message' => 'User deleted successfully'], JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to delete user'], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'User ID is required for deletion'], JSON_UNESCAPED_UNICODE);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
                break;
        }
    }
}
