<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route("/{wildcard}", name: "app_index", requirements: ["wildcard" => ".*"])]
    public function index(): Response
    {
        return $this->render("index.html.twig", []);
    }
}