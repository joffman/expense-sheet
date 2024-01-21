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

class ExpenseApiController extends AbstractController
{
    #[Route("/api/expenses", methods: ["GET"])]
    public function getExpenses(LoggerInterface $logger, ExpenseRepository $repository): JsonResponse
    {
        $expenses = $repository->findAll();

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
        // todo handle invalid input data (send 400 reponse).
        $requestData = json_decode($request->getContent(), true);
        $date = \DateTimeImmutable::createFromFormat("Ymd", $requestData["date"]);

        $expense = new Expense();
        $expense->setName($requestData["name"]);
        $expense->setDate($date);
        $expense->setCosts($requestData["costs"]);
        $expense->setPaymentSource($requestData["paymentSource"]);

        $entityManager->persist($expense);
        $entityManager->flush();

        $responseData = [
            "id" => $expense->getId()
        ];

        return $this->json($responseData);
    }
}