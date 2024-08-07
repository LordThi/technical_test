<?php

namespace App\Controller\Api;

use App\Entity\ThemeQuestion;
use App\Form\ThemeQuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuestionThemeController extends AbstractController
{
    #[Route('/api/questions_themes', name: "api_questions_themes_get", methods: ['GET'])]
    public function getThemes(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(ThemeQuestion::class)->findAll();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = [
                'id' => $theme->getId(),
                'titre' => $theme->getTitre()
            ];
        }
        return $this->json($data);
    }
}
