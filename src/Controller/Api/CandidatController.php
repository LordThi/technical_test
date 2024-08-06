<?php

namespace App\Controller\Api;

use App\Entity\Candidat;
use App\Entity\Niveau;
use App\Entity\Quiz;
use App\Entity\TypePoste;
use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class CandidatController extends AbstractController
{
    private CandidatRepository $candidatRepository;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(CandidatRepository $candidatRepository, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->candidatRepository = $candidatRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/api/candidat", name="create_candidat", methods={"POST"})
     */
    #[Route('/api/candidat', name: 'create_candidat', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $candidat = new Candidat();
        $candidat->setNom($data['lastname']);
        $candidat->setPrenom($data['firstname']);
        $candidat->setEmail($data['mail']);
//        $candidat->setQuiz($this->entityManager->getRepository(Quiz::class)->find($data['quiz_id']));
//        $candidat->setNiveau($this->entityManager->getRepository(Niveau::class)->find($data['niveau_id']));
//        $candidat->setTypePoste($this->entityManager->getRepository(TypePoste::class)->find($data['type_poste_id']));
//        $candidat->setTempsTotal($data['temps_total']);
        $candidat->setDatePassage(new \DateTime());

        $errors = $this->validator->validate($candidat);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($candidat);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Candidat created successfully', 'candidat' => $candidat], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/candidat/{id}", name="get_candidat", methods={"GET"})
     */
    #[Route('/api/candidat/{id}', name: 'get_candidat', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $candidat = $this->candidatRepository->find($id);

        if (!$candidat) {
            return new JsonResponse(['message' => 'Candidat not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($candidat, Response::HTTP_OK);
    }

    /**
     * @Route("/api/candidat/{id}", name="update_candidat", methods={"PUT"})
     */
    #[Route('/api/candidat/{id}', name: 'update_candidat', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $candidat = $this->candidatRepository->find($id);

        if (!$candidat) {
            return new JsonResponse(['message' => 'Candidat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $candidat->setNom($data['lastname'] ?? $candidat->getNom());
        $candidat->setPrenom($data['firstname'] ?? $candidat->getPrenom());
        $candidat->setEmail($data['mail'] ?? $candidat->getEmail());
        $candidat->setQuiz($this->entityManager->getRepository(Quiz::class)->find($data['quiz_id'] ?? $candidat->getQuiz()->getId()));
        $candidat->setNiveau($this->entityManager->getRepository(Niveau::class)->find($data['niveau_id'] ?? $candidat->getNiveau()->getId()));
        $candidat->setTypePoste($this->entityManager->getRepository(TypePoste::class)->find($data['type_poste_id'] ?? $candidat->getTypePoste()->getId()));
        $candidat->setTempsTotal($data['temps_total'] ?? $candidat->getTempsTotal());
        $candidat->setDatePassage(new \DateTime());

        $errors = $this->validator->validate($candidat);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Candidat updated successfully', 'candidat' => $candidat], Response::HTTP_OK);
    }

    /**
     * @Route("/api/candidat/{id}", name="delete_candidat", methods={"DELETE"})
     */
    #[Route('/api/candidat/{id}', name: 'delete_candidat', methods: ['DELETE'])]
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
