<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use App\Entity\User;
use App\Model\UserRegisterDTO;
use App\Repository\OrganizationRepository;

#[Route('/api', defaults: ['_format' => 'json'])]
final class ApiLoginController extends AbstractController
{
    #[Route('/login', name: 'app_api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (is_null($user)) {
            return $this->json(
                ['error' => 'invalid user credentials'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());

        return $this->json([
            'email' => $user->getUserIdentifier(),
            'name' => $user->getName(),
            'token' => $token,
        ]);
    }

    #[Route('/register', name: 'app_api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        UserRegisterDTO             $request,
        UserPasswordHasherInterface $passwordHasher,
        OrganizationRepository      $organizationRepository,
        EntityManagerInterface      $em,
    ): JsonResponse
    {
        $organization = null;
        if (!is_null($request->organizationID)) {
            $organization = $organizationRepository->find($request->organizationID);

            if (is_null($organization)) {
                return $this->json(
                    ['error' => 'invalid organization'], Response::HTTP_BAD_REQUEST
                );
            }
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
            ], Response::HTTP_CREATED
        );
    }
}
