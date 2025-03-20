<?php


use Helper\Reply;
use App\Controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

$userController = new UserController();
$terminalController = new \App\Controllers\TerminalController();

switch (true) {
    case $parsedUrl === '/api/users' && $requestMethod === 'POST':
        try {
            $userController->saveUser();
        } catch (Exception $e) {
            Reply::_error($e->getMessage());
        }
        break;
    case $parsedUrl === '/api/auth' && $requestMethod === 'PUT':
        try {
            $userController->authUser();
        } catch (Exception $e) {
            Reply::_error($e->getMessage());
        }
        break;
    case $parsedUrl === '/terminal/' && $requestMethod === 'POST':
        try {
            $terminalController->getBearerToken();
        } catch (Exception $e) {
            Reply::_error($e->getMessage());
        }
        break;

    default: Reply::_error('rout_not_found');
}
