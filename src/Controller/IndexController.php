<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    #[Route("/")]
    public function index()
    {
        die("index is not implemented yet");
    }
}