<?php

namespace App\Controllers;

use App\Services\SurveyService;

class Survey
{
    public function getSurvey()
    {
        $survey = [
            "token" => "100001",
            "label" => "test sur le survey",
            "debut" => "2025-03-27 12:00",
            "fin" => "2025-03-28 12:00",
            "completed" => false,
            "questions" => [
                [
                    "token" => "100001",
                    "name" => "Comment évaluez-vous la qualité du service ?",
                    "description" => "Satisfaction générale",
                    "position" => 1,
                    "required" => true,
                    "family" => "radio",
                    "responses" => [
                        ["token" => "100001", "name" => "Très satisfait", "position" => 1],
                        ["token" => "100002", "name" => "Satisfait", "position" => 2],
                        ["token" => "100003", "name" => "Neutre", "position" => 3],
                        ["token" => "100004", "name" => "Insatisfait", "position" => 4],
                        ["token" => "100005", "name" => "Très insatisfait", "position" => 5]
                    ]
                ],
                [
                    "token" => "100002",
                    "name" => "Quels aspects du service appréciez-vous ?",
                    "description" => "Choisissez plusieurs options",
                    "position" => 2,
                    "required" => false,
                    "family" => "checkbox",
                    "responses" => [
                        ["token" => "100006", "name" => "Rapidité du service", "position" => 1],
                        ["token" => "100007", "name" => "Qualité des produits", "position" => 2],
                        ["token" => "100008", "name" => "Accueil du personnel", "position" => 3],
                        ["token" => "100009", "name" => "Propreté des lieux", "position" => 4],
                        ["token" => "100010", "name" => "Service client toujours a jour", "position" => 5]
                    ]
                ],
                [
                    "token" => "100003",
                    "name" => "Veuillez donner une note globale au service",
                    "description" => "Attribuez une note de 1 à 5 étoiles",
                    "position" => 3,
                    "required" => true,
                    "family" => "stars",
                    "responses" => null
                ],
                [
                    "token" => "100004",
                    "name" => "Avez-vous des suggestions ou commentaires à nous faire ?",
                    "description" => "Exprimez vous brievement",
                    "position" => 4,
                    "required" => false,
                    "family" => "shortext",
                    "responses" => []
                ],
                [
                    "token" => "100005",
                    "name" => "Avez-vous des suggestions ou commentaires à nous faire ?",
                    "description" => "Exprimez librement votre avis",
                    "position" => 5,
                    "required" => false,
                    "family" => "longtext",
                    "responses" => []
                ]
            ]
        ];


        SurveyService::json($survey);
    }
}
