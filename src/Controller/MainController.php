<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/{reactRouting}', name: 'homepage', requirements: ['reactRouting' => '^(?!api).*$'], defaults: ['reactRouting' => null])]
    public function index()
    {
        return $this->render('base.html.twig');
    }
}
