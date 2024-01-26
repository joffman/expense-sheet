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
 * - Adjust 404 error response. Don't send html. Also check behaviour for production.
 * - Authentication
 * - Add comment field.
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

    #[Route("/api/expenses/{id}", methods: ["GET"])]
    public function getExpenseById(Expense $expense): JsonResponse
    {
        $expenseData = [
            "id" => $expense->getId(),
            "name" => $expense->getName(),
            "date" => $expense->getDate(),
            "costs" => $expense->getCosts(),
            "paymentSource" => $expense->getPaymentSource(),
        ];

        return $this->json($expenseData);
    }

    #[Route("/api/expenses/{id}", methods: ["POST"])]
    public function updateExpense($id, ExpenseRepository $repository, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (is_null($requestData)) {
            return new JsonResponse(["error" => "Request body is not valid JSON"], 400);
        }

        $date = \DateTimeImmutable::createFromFormat("Ymd", $requestData["date"]);
        if ($date === false) {
            return new JsonResponse(["error" => "Invalid date format"], 400);
        }

        $expense = $repository->find($id);
        if (is_null($expense)) {
            return new JsonResponse(["error" => "expense object does not exist"], 400);
        }

        try {
            $expense->setName($requestData["name"] ?? null);
            $expense->setDate($date);
            $expense->setCosts($requestData["costs"] ?? null);
            $expense->setPaymentSource($requestData["paymentSource"] ?? null);
        } catch (\TypeError $e) {
            return new JsonResponse(["error" => "Invalid inputs: " . $e], 400);
        }

        $entityManager->flush();

        $responseData = [
            "success" => true,
        ];
        return $this->json($responseData);
    }

    #[Route("/api/expenses/{id}", methods: ["DELETE"])]
    public function deleteExpense(Expense $expense, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($expense);
        $entityManager->flush();

        $responseData = [
            "success" => true,
        ];

        return $this->json($responseData);
    }

    #[Route("/api/expenses", methods: ["POST"])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (is_null($requestData)) {
            return new JsonResponse(["error" => "Request body is not valid JSON"], 400);
        }

        $date = \DateTimeImmutable::createFromFormat("Ymd", $requestData["date"]);
        if ($date === false) {
            return new JsonResponse(["error" => "Invalid date format"], 400);
        }

        $expense = new Expense();
        try {
            $expense->setName($requestData["name"] ?? null);
            $expense->setDate($date);
            $expense->setCosts($requestData["costs"] ?? null);
            $expense->setPaymentSource($requestData["paymentSource"] ?? null);
        } catch (\TypeError $e) {
            return new JsonResponse(["error" => "Invalid inputs: " . $e], 400);
        }

        $entityManager->persist($expense);
        $entityManager->flush();

        $responseData = [
            "id" => $expense->getId()
        ];

        return $this->json($responseData);
    }
}