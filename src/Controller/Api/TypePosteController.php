<?php

namespace App\Controller\Api;

use App\Entity\TypePoste;
use App\Repository\TypePosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Annotation\Groups;

class TypePosteController extends AbstractController
{
    private TypePosteRepository $typePosteRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TypePosteRepository $typePosteRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->typePosteRepository = $typePosteRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/types_poste', name: 'api_get_types_poste', methods: ['GET'])]
    public function getTypesPoste(): JsonResponse
    {
        $typesPoste = $this->typePosteRepository->findAll();
        $data = $this->serializer->normalize($typesPoste, null, ['groups' => 'type_poste:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/types_poste/{id}', name: 'api_get_type_poste', methods: ['GET'])]
    public function getTypePoste(int $id): JsonResponse
    {
        $typePoste = $this->typePosteRepository->find($id);
        if (!$typePoste) {
            throw new NotFoundHttpException('TypePoste not found');
        }
        $data = $this->serializer->normalize($typePoste, null, ['groups' => 'type_poste:read']);
        return new JsonResponse($data);
    }

    #[Route('/api/types_poste', name: 'api_create_type_poste', methods: ['POST'])]
    public function createTypePoste(Request $request): JsonResponse
    {
        $data = $request->getContent();
        $typePoste = $this->serializer->deserialize($data, TypePoste::class, 'json');

        $this->entityManager->persist($typePoste);
        $this->entityManager->flush();

        $response = $this->serializer->normalize($typePoste, null, ['groups' => 'type_poste:read']);
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    #[Route('/api/types_poste/{id}', name: 'api_update_type_poste', methods: ['PUT'])]
    public function updateTypePoste(Request $request, int $id): JsonResponse
    {
        $typePoste = $this->typePosteRepository->find($id);
        if (!$typePoste) {
            throw new NotFoundHttpException('TypePoste not found');
        }

        $data = $request->getContent();
        $this->serializer->deserialize($data, TypePoste::class, 'json', ['object_to_populate' => $typePoste]);

        $this->entityManager->flush();

        $response = $this->serializer->normalize($typePoste, null, ['groups' => 'type_poste:read']);
        return new JsonResponse($response);
    }

    #[Route('/api/types_poste/{id}', name: 'api_delete_type_poste', methods: ['DELETE'])]
    public function deleteTypePoste(int $id): JsonResponse
    {
        $typePoste = $this->typePosteRepository->find($id);
        if (!$typePoste) {
            throw new NotFoundHttpException('TypePoste not found');
        }

        $this->entityManager->remove($typePoste);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'TypePoste deleted'], Response::HTTP_NO_CONTENT);
    }
}
