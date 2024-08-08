<?php

namespace App\Controller\Api;

use App\Entity\Candidat;
use App\Entity\Niveau;
use App\Entity\Quiz;
use App\Entity\TypePoste;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class CandidatController extends AbstractController
{
    private CandidatRepository $candidatRepository;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(
        CandidatRepository $candidatRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->candidatRepository = $candidatRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    #[Route('/api/candidats', name: 'api_get_candidats', methods: ['GET'])]
    public function getCandidats(): JsonResponse
    {
        $candidats = $this->candidatRepository->findAll();
        $data = array_map(function ($candidat) {
            return [
                'id' => $candidat->getId(),
                'nom' => $candidat->getNom(),
                'prenom' => $candidat->getPrenom(),
                'email' => $candidat->getEmail(),
                'quiz' => $candidat->getQuiz()->getTitre(),
                'niveau' => $candidat->getNiveau()->getTitre(),
                'typePoste' => $candidat->getTypePoste()->getTitre(),
                'tempsTotal' => $candidat->getTempsTotal(),
                'datePassage' => $candidat->getDatePassage(),
            ];
        }, $candidats);

        return new JsonResponse($data);
    }

    #[Route('/api/candidats', name: 'api_create_candidat', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $candidat = new Candidat();
        $candidat->setNom($data['nom'] ?? '');
        $candidat->setPrenom($data['prenom'] ?? '');
        $candidat->setEmail($data['email'] ?? '');

        if (isset($data['quizId'])) {
            $quiz = $this->entityManager->getRepository(Quiz::class)->find($data['quizId']);
            if ($quiz) {
                $candidat->setQuiz($quiz);
            }
        }
        if (isset($data['niveauId'])) {
            $niveau = $this->entityManager->getRepository(Niveau::class)->find($data['niveauId']);
            if ($niveau) {
                $candidat->setNiveau($niveau);
            }
        }
        if (isset($data['typePosteId'])) {
            $typePoste = $this->entityManager->getRepository(TypePoste::class)->find($data['typePosteId']);
            if ($typePoste) {
                $candidat->setTypePoste($typePoste);
            }
        }
        $candidat->setTempsTotal($data['temps_total'] ?? 0);
        if (!$data['adminDashboard']){
            $candidat->setDatePassage(new \DateTime());
        }
        $errors = $this->validator->validate($candidat);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($candidat);
        $this->entityManager->flush();

        $response = $this->serializer->normalize($candidat, null, ['groups' => 'candidat:read']);
        return new JsonResponse(['message' => 'Candidat created successfully', 'candidat' => $response], Response::HTTP_CREATED);
    }

    #[Route('/api/candidats/{id}', name: 'get_candidat', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $candidat = $this->candidatRepository->find($id);

        if (!$candidat) {
            return new JsonResponse(['message' => 'Candidat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializer->normalize($candidat, null, ['groups' => 'candidat:read']);
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/candidats/{id}', name: 'update_candidat', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $candidat = $this->candidatRepository->find($id);

        if (!$candidat) {
            return new JsonResponse(['message' => 'Candidat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $candidat->setNom($data['nom'] ?? $candidat->getNom());
        $candidat->setPrenom($data['prenom'] ?? $candidat->getPrenom());
        $candidat->setEmail($data['email'] ?? $candidat->getEmail());
        if (isset($data['quizId'])) {
            $quiz = $this->entityManager->getRepository(Quiz::class)->find($data['quizId']);
            if ($quiz) {
                $candidat->setQuiz($quiz);
            }
        }
        if (isset($data['niveauId'])) {
            $niveau = $this->entityManager->getRepository(Niveau::class)->find($data['niveauId']);
            if ($niveau) {
                $candidat->setNiveau($niveau);
            }
        }
        if (isset($data['typePosteId'])) {
            $typePoste = $this->entityManager->getRepository(TypePoste::class)->find($data['typePosteId']);
            if ($typePoste) {
                $candidat->setTypePoste($typePoste);
            }
        }
        $candidat->setTempsTotal($data['temps_total'] ?? $candidat->getTempsTotal());
        if (!$data['adminDashboard']) {
            $candidat->setDatePassage(new \DateTime());
        }
        $errors = $this->validator->validate($candidat);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        $response = $this->serializer->normalize($candidat, null, ['groups' => 'candidat:read']);
        return new JsonResponse(['message' => 'Candidat updated successfully', 'candidat' => $response], Response::HTTP_OK);
    }

    #[Route('/api/candidats/{id}', name: 'delete_candidat', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $candidat = $this->candidatRepository->find($id);

        if (!$candidat) {
            return new JsonResponse(['message' => 'Candidat not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($candidat);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Candidat deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
