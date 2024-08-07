<?php

namespace App\Controller\Api;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Annotation\Groups;

class QuizController extends AbstractController
{
    private QuizRepository $quizRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        QuizRepository $quizRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->quizRepository = $quizRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/quizzes', name: 'api_get_quizzes', methods: ['GET'])]
    public function getQuizzes(): JsonResponse
    {
        $quizzes = $this->quizRepository->findAll();
        $data = $this->serializer->normalize($quizzes, null, ['groups' => 'quiz:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/quizzes/{id}', name: 'api_get_quiz', methods: ['GET'])]
    public function getQuiz(int $id): JsonResponse
    {
        $quiz = $this->quizRepository->find($id);
        if (!$quiz) {
            throw new NotFoundHttpException('Quiz not found');
        }
        $data = $this->serializer->normalize($quiz, null, ['groups' => 'quiz:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/quizzes', name: 'api_create_quiz', methods: ['POST'])]
    public function createQuiz(Request $request): JsonResponse
    {
        $data = $request->getContent();
        $quiz = $this->serializer->deserialize($data, Quiz::class, 'json');

        $this->entityManager->persist($quiz);
        $this->entityManager->flush();

        $response = $this->serializer->normalize($quiz, null, ['groups' => 'quiz:read']);
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    #[Route('/api/quizzes/{id}', name: 'api_update_quiz', methods: ['PUT'])]
    public function updateQuiz(Request $request, int $id): JsonResponse
    {
        $quiz = $this->quizRepository->find($id);
        if (!$quiz) {
            throw new NotFoundHttpException('Quiz not found');
        }

        $data = $request->getContent();
        $this->serializer->deserialize($data, Quiz::class, 'json', ['object_to_populate' => $quiz]);

        $this->entityManager->flush();

        $response = $this->serializer->normalize($quiz, null, ['groups' => 'quiz:read']);
        return new JsonResponse($response);
    }

    #[Route('/api/quizzes/{id}', name: 'api_delete_quiz', methods: ['DELETE'])]
    public function deleteQuiz(int $id): JsonResponse
    {
        $quiz = $this->quizRepository->find($id);
        if (!$quiz) {
            throw new NotFoundHttpException('Quiz not found');
        }

        $this->entityManager->remove($quiz);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Quiz deleted'], Response::HTTP_NO_CONTENT);
    }
}
