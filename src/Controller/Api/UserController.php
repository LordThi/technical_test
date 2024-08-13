<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/users', name: 'api_get_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = $this->serializer->normalize($users, null, ['groups' => 'user:read']);
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/users/{id}', name: 'api_get_user', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'L\'utilisateur n\'a pas été trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializer->normalize($user, null, ['groups' => 'user:read']);
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/users', name: 'api_create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setPrenom($data['prenom']);
        $user->setLogin($data['login']);
        $user->setPassword($data['password']);
        $user->setStatut($data['statut']);

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $response = $this->serializer->normalize($user, null, ['groups' => 'user:read']);
        return new JsonResponse(['message' => 'L\'utilisateur a été créé', 'user' => $response], Response::HTTP_CREATED);
    }

    #[Route('/api/users/{id}', name: 'api_update_user', methods: ['PUT'])]
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'L\'utilisateur n\'a pas été trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $user->setPrenom($data['prenom'] ?? $user->getPrenom());
        $user->setLogin($data['login'] ?? $user->getLogin());
        $user->setPassword($data['password'] ?? $user->getPassword());
        $user->setStatut($data['statut'] ?? $user->getStatut());

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        $response = $this->serializer->normalize($user, null, ['groups' => 'user:read']);
        return new JsonResponse(['message' => 'L\'utilisateur à été mis à jour', 'user' => $response], Response::HTTP_OK);
    }

    #[Route('/api/users/{id}', name: 'api_delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'L\'utilisateur n\'a pas été trouvé'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'L\'utilisateur a bien été effacé'], Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        $user = $this->userRepository->findOneBy(['login' => $login]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['message' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = 'tokenAFaire'; // TODO gestion creation token via jwtTokenManager

        return new JsonResponse(['token' => $token]);
    }
}
