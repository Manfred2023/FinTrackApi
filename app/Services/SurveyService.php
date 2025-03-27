<?php

namespace App\Services;

class SurveyService
{
    public static function json($data, $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}
