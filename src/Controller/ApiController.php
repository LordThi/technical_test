<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/data', name: 'api_data', methods: ['GET'])]
    public function getData(): JsonResponse
    {
        $data = [
            'message' => 'Hello, this is your data!',
            'date' => (new \DateTime())->format('Y-m-d H:i:s'),
            'company' => [
                'name' => 'Axe E-Santé',
            ],
        ];

        return new JsonResponse($data);
    }
}