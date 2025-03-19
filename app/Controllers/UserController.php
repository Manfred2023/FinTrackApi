<?php

namespace App\Controllers;
use App\Services\UserService;
use Helper\Reply;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function saveUser()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nickname'], $data['email'],$data['mobile'],$data['pin'],  )) {
             Reply::_error('fields missing',code: 400);
        }
        if($data['token'] != null ){
            $userId = $this->userService->createUser($data['token'],$data['nickname'], $data['email'],$data['mobile'], $data['pin'],);

        }else{
            $userId = $this->userService->createUser($data['token'],$data['nickname'], $data['email'],$data['mobile'], $data['pin'],);
        }

        Reply::_success($userId->toArray());

    }

    public function getUser($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(["error" => "Utilisateur non trouvé"]);
            return;
        }

        echo json_encode([
            "id" => $user->getId(),
            "nickname" => $user->getNickname(),
            "email" => $user->getEmail(),
            "admin" => $user->getAdmin(),
            "blocked" => $user->getBlocked()
        ]);
    }

    public function getAllUsers()
    {
        $users = $this->userService->getAllUsers();
        echo json_encode($users);
    }

    public function updateUser($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->userService->updateUser($id, $data)) {
            echo json_encode(["message" => "Utilisateur mis à jour"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Échec de la mise à jour"]);
        }
    }

    public function deleteUser($id)
    {
        if ($this->userService->deleteUser($id)) {
            echo json_encode(["message" => "Utilisateur supprimé"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Échec de la suppression"]);
        }
    }
}
