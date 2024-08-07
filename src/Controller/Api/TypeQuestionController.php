<?php

namespace App\Controller\Api;

use App\Entity\TypeQuestion;
use App\Form\TypeQuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TypeQuestionController extends AbstractController
{
#[Route('/api/questions_types', name: 'api_questions_types_get', methods: ['GET'])]
    public function getTypes(EntityManagerInterface $em): Response
    {
        $types = $em->getRepository(TypeQuestion::class)->findAll();
        $data = [];
        foreach ($types as $type) {
            $data[] = [
                'id' => $type->getId(),
                'titre' => $type->getTitre()
            ];
        }
        return $this->json($data);
    }
}
