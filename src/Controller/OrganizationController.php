<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Entity\Organization;
use App\Repository\OrganizationRepository;

final class OrganizationController extends AbstractController
{
    #[Route('/api/organizations', name: 'app_organization_list', methods: ['GET'])]
    public function list(OrganizationRepository $organizationRepository): JsonResponse
    {
        $organizations = $organizationRepository->findAll();

        return $this->json($organizations);
    }

    #[Route('/api/organizations', name: 'app_organization_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] Organization $organization, EntityManagerInterface $em): JsonResponse
    {
        $em->persist($organization);
        $em->flush();

        return $this->json([
            'id' => $organization->getId(),
            'name' => $organization->getName(),
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/organizations/{id}', name: 'app_organization_show', methods: ['GET'])]
    public function show(Organization $organization): JsonResponse
    {
        return $this->json($organization);
    }
}
