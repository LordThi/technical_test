<?php

namespace App\Controller\Api;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Annotation\Groups;

class NiveauController extends AbstractController
{
    private NiveauRepository $niveauRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        NiveauRepository $niveauRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->niveauRepository = $niveauRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/niveaux', name: 'api_get_niveaux', methods: ['GET'])]
    public function getNiveaux(): JsonResponse
    {
        $niveaux = $this->niveauRepository->findAll();
        $data = $this->serializer->normalize($niveaux, null, ['groups' => 'niveau:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/niveaux/{id}', name: 'api_get_niveau', methods: ['GET'])]
    public function getNiveau(int $id): JsonResponse
    {
        $niveau = $this->niveauRepository->find($id);
        if (!$niveau) {
            throw new NotFoundHttpException('Niveau not found');
        }
        $data = $this->serializer->normalize($niveau, null, ['groups' => 'niveau:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/niveaux', name: 'api_create_niveau', methods: ['POST'])]
    public function createNiveau(Request $request): JsonResponse
    {
        $data = $request->getContent();
        $niveau = $this->serializer->deserialize($data, Niveau::class, 'json');

        $this->entityManager->persist($niveau);
        $this->entityManager->flush();

        $response = $this->serializer->normalize($niveau, null, ['groups' => 'niveau:read']);
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    #[Route('/api/niveaux/{id}', name: 'api_update_niveau', methods: ['PUT'])]
    public function updateNiveau(Request $request, int $id): JsonResponse
    {
        $niveau = $this->niveauRepository->find($id);
        if (!$niveau) {
            throw new NotFoundHttpException('Niveau not found');
        }

        $data = $request->getContent();
        $this->serializer->deserialize($data, Niveau::class, 'json', ['object_to_populate' => $niveau]);

        $this->entityManager->flush();

        $response = $this->serializer->normalize($niveau, null, ['groups' => 'niveau:read']);
        return new JsonResponse($response);
    }

    #[Route('/api/niveaux/{id}', name: 'api_delete_niveau', methods: ['DELETE'])]
    public function deleteNiveau(int $id): JsonResponse
    {
        $niveau = $this->niveauRepository->find($id);
        if (!$niveau) {
            throw new NotFoundHttpException('Niveau not found');
        }

        $this->entityManager->remove($niveau);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Niveau deleted'], Response::HTTP_NO_CONTENT);
    }
}
