<?php

namespace App\Controller\Api;

use App\Entity\Difficulte;
use App\Form\DifficulteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DifficulteController extends AbstractController
{
    /**
     * @Route("/api/difficultes", name="get_difficultes", methods={"GET"})
     */
    #[Route('/api/difficultes', name:'get_difficultes', methods:['GET'])]
    public function getDifficultes(EntityManagerInterface $em): Response
    {
        $difficultes = $em->getRepository(Difficulte::class)->findAll();
        $data = [];
        foreach ($difficultes as $difficulte) {
            $data[] = [
                'id' => $difficulte->getId(),
                'titre' => $difficulte->getTitre()
            ];
        }
        return $this->json($data);
    }
}
