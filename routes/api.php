<?php


use App\Controllers\AccountController;
use App\Controllers\TerminalController;
use App\Middlewares\AuthMiddleware;
use Helper\Reply;
use App\Controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

$userController = new UserController();
$accountController = new AccountController();
$terminalController = new TerminalController();

switch (true) {
    case $parsedUrl === '/api/users' && $requestMethod === 'POST':
            AuthMiddleware::handle();
            $userController->saveUser();
    case $parsedUrl === '/api/auth' && $requestMethod === 'PUT':
        AuthMiddleware::handle();
            $userController->authUser();
    case $parsedUrl === '/balance' && $requestMethod === 'PUT':
        AuthMiddleware::handle();
            $accountController->getBalance();
        break;
    case $parsedUrl === '/terminal/' && $requestMethod === 'POST':
            $terminalController->getBearerToken();
        break;

    default: Reply::_error('rout_not_found',code: 404);
}
