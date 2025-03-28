<?php


use App\Controllers\AccountController;
use App\Controllers\ContactController;
use App\Controllers\MotifController;
use App\Controllers\Survey;
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
$motifController = new MotifController();
$contactController = new ContactController();
$surveyController = new  Survey();

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
    case $parsedUrl === '/motif/create' && $requestMethod === 'POST':
        AuthMiddleware::handle();
            $motifController->createMotif();
        break;
    case $parsedUrl === '/motif/' && $requestMethod === 'PUT':
        AuthMiddleware::handle();
            $motifController->getAllMotif();
        break;
    case $parsedUrl === '/api/survey' && $requestMethod === 'GET':
            $surveyController->getSurvey();
        break;
    case $parsedUrl === '/contact/save' && $requestMethod === 'POST':
            AuthMiddleware::handle();
            $contactController->saveContact();
        break;
    case $parsedUrl === '/contact' && $requestMethod === 'PUT':
            AuthMiddleware::handle();
            $contactController->getAllContactsByAccount();
        break;
    case $parsedUrl === '/contact/all' && $requestMethod === 'GET':
            AuthMiddleware::handle();
            $userController->getAllUser();
        break;
        case $parsedUrl === '/account/all' && $requestMethod === 'GET':
            AuthMiddleware::handle();
            $accountController->getAllAccount();
        break;

    default: Reply::_error('rout_not_found',code: 404);
}
