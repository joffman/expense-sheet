<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExpenseApiController extends AbstractController
{
    #[Route("/api/expenses", methods: ["GET"])]
    public function getExpenses(): JsonResponse
    {
        $expenses = [
            [
                "title" => "Einkaufen",
                "cost" => 15,
                "date" => date("Y-m-d", mktime(0, 0, 0, 12, 5, 2023))
            ],
            [
                "title" => "Putzfrau",
                "cost" => 45,
                "date" => date("Y-m-d", mktime(0, 0, 0, 1, 3, 2024))
            ],
        ];

        return $this->json($expenses);
    }
}