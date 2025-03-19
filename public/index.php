<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclusion des routes
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/databaseScheme.php';
Database::connect();
DBInit::initialize();
require_once __DIR__ . '/../routes/api.php';
