<?php

namespace App\Controller;

use App\Entity\Expense;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpenseApiController extends AbstractController
{
    #[Route("/api/expenses", methods: ["GET"])]
    public function getExpenses(LoggerInterface $logger): JsonResponse
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

        $logger->info("Return {expenseCount} expenses", [
            "expenseCount" => count($expenses)
        ]);

        return $this->json($expenses);
    }

    #[Route("/api/expenses", methods: ["POST"])]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $expense = new Expense();
        $expense->setName("Putzfrau");
        $expense->setDate(new \DateTimeImmutable());
        $expense->setCosts(45);
        $expense->setPaymentSource("Janosch");

        $entityManager->persist($expense);
        $entityManager->flush();

        $responseData = [
            "id" => $expense->getId()
        ];

        return $this->json($responseData);
    }
}