<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpenseController
{
    #[Route("/api/expenses")]
    public function getExpenses() : Response
    {
        die("getExpenses is not implemented");
    }
}