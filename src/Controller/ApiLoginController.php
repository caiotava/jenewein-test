<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use App\Model\UserRegisterDTO;
use App\Model\UserResponseDTO;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;

#[Route('/api', defaults: ['_format' => 'json'])]
final class ApiLoginController extends AbstractController
{
    #[Route('/login', name: 'app_api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user, JWTTokenManagerInterface $jwtManager): Response
    {
        if (is_null($user)) {
            return $this->json(
                ['error' => 'invalid user credentials'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $jwtManager->create($user);

        return $this->json(new UserResponseDTO($user, $token));
    }

    #[Route('/register', name: 'app_api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        UserRegisterDTO $request,
        UserPasswordHasherInterface $passwordHasher,
        OrganizationRepository $organizationRepository,
        UserRepository $userRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $organization = null;
        if (!is_null($request->organization_id)) {
            $organization = $organizationRepository->find($request->organization_id);

            if (is_null($organization)) {
                return $this->json(
                    ['error' => 'invalid organization'],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        $userExists = $userRepository->findOneBy(['email' => $request->email]);
        if (!is_null($userExists)) {
            return $this->json(['error' => 'user already exists'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setName($request->name);
        $user->setEmail($request->email);
        $user->setPassword($passwordHasher->hashPassword($user, $request->password));
        $user->setRoles([$request->role]);
        $user->setOrganization($organization);

        $em->persist($user);
        $em->flush();

        return $this->json(
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ],
            Response::HTTP_CREATED
        );
    }
}
