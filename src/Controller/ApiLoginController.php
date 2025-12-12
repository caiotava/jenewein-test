<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use App\Entity\User;

final class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): Response
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
}
