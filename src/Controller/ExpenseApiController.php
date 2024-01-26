<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/* todo
 * - get all: order by date descending
 * - get one Endpunkt
 * - update Endpunkt
 * - delete Endpunkt
 * - Error Handling
 * - Authentication
 * - later: statistics
 */

class ExpenseApiController extends AbstractController
{
    #[Route("/api/expenses", methods: ["GET"])]
    public function getExpenses(LoggerInterface $logger, ExpenseRepository $repository): JsonResponse
    {
        $expenses = $repository->findBy([], ["date" => "DESC"]);

        $data = [];
        foreach ($expenses as $expense) {
            $data[] = [
                "id" => $expense->getId(),
                "name" => $expense->getName(),
                "date" => $expense->getDate(),
                "costs" => $expense->getCosts(),
                "paymentSource" => $expense->getPaymentSource(),
            ];
        }

        $logger->info("Return {expenseCount} expenses", [
            "expenseCount" => count($expenses)
        ]);

        return $this->json($data);
    }

    #[Route("/api/expenses", methods: ["POST"])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        if (is_null($requestData)) {
            return new Response("Request body is not valid JSON", 400);
        }

        $date = \DateTimeImmutable::createFromFormat("Ymd", $requestData["date"]);
        if ($date === false) {
            return new Response("Invalid date format", 400);
        }

        $expense = new Expense();
        try {
            $expense->setName($requestData["name"] ?? null);
            $expense->setDate($date);
            $expense->setCosts($requestData["costs"] ?? null);
            $expense->setPaymentSource($requestData["paymentSource"] ?? null);
        } catch (\TypeError $e) {
            return new Response("Invalid inputs: " . $e, 400);
        }

        $entityManager->persist($expense);
        $entityManager->flush();

        $responseData = [
            "id" => $expense->getId()
        ];

        return $this->json($responseData);
    }
}