<?php


use Helper\Reply;
use App\Controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

$userController = new UserController();

switch (true) {
    case $parsedUrl === '/api/users' && $requestMethod === 'POST':
        $userController->saveUser();
        break;

    case $parsedUrl === '/api/users' && $requestMethod === 'GET':
        $userController->getAllUsers();
        break;

   /* case preg_match('/\/api\/users\/(\d+)/', $parsedUrl, $matches):
        $userId = (int) $matches[1];

        switch ($requestMethod) {
            case 'GET':
                $userController->getUser($userId);
                break;
            case 'PUT':
                $userController->updateUser($userId);
                break;
            case 'DELETE':
                $userController->deleteUser($userId);
                break;
            default:
                http_response_code(405);
                echo json_encode(["error" => "Méthode non autorisée"]);
        }
        break;*/

    default: Reply::_error('rout_not_found');
}
