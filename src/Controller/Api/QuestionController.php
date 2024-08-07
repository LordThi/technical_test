<?php
// src/Controller/Api/QuestionApiController.php
namespace App\Controller\Api;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionController extends AbstractController
{
    #[Route('/api/questions', name: 'api_question_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $questions = $em->getRepository(Question::class)->findAll();
        $json = $serializer->serialize($questions, 'json', ['groups' => 'question:read']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/questions/{id}', name: 'api_question_get', methods: ['GET'])]
    public function get(Question $question, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($question, 'json', ['groups' => 'question:read']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/questions', name: 'api_question_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['errors' => $form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
        }

        $em->persist($question);
        $em->flush();

        return new JsonResponse($serializer->serialize($question, 'json', ['groups' => 'question:read']), Response::HTTP_CREATED, [], true);
    }

    #[Route('/api/questions/{id}', name: 'api_question_update', methods: ['PUT'])]
    public function update(Request $request, Question $question, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(QuestionType::class, $question);
        $form->submit($data, false);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['errors' => $form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        return new JsonResponse($serializer->serialize($question, 'json', ['groups' => 'question:read']), Response::HTTP_OK, [], true);
    }

    #[Route('/api/questions/{id}', name: 'api_question_delete', methods: ['DELETE'])]
    public function delete(Question $question, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($question);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
