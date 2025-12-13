<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Organization;
use App\Model\OrganizationRequestDTO;
use App\Model\OrganizationResponseDTO;
use App\Repository\OrganizationRepository;
use App\Service\Pagination\Paginator;

#[IsGranted('ROLE_SUPER_ADMIN')]
final class OrganizationController extends AbstractController
{
    #[Route('/api/organizations', name: 'app_organization_list', methods: ['GET'])]
    public function list(OrganizationRepository $organizationRepo, Request $request, Paginator $paginator): JsonResponse
    {
        $queryBuilder = $organizationRepo->createQueryBuilder("o")->orderBy('o.id', 'ASC');
        $result = $paginator->paginate($queryBuilder, $request);

        return $this->json($result->convertItemsToDTO(OrganizationResponseDTO::class));
    }

    #[Route('/api/organizations', name: 'app_organization_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] OrganizationRequestDTO $payload,
        EntityManagerInterface $em
    ): JsonResponse {
        $organization = new Organization();
        $organization->setName($payload->name);

        $em->persist($organization);
        $em->flush();

        return $this->json(new OrganizationResponseDTO($organization), JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/organizations/{id}', name: 'app_organization_update', methods: ['PUT'])]
    public function update(
        #[MapRequestPayload] OrganizationRequestDTO $payload,
        Organization $organization,
        EntityManagerInterface $em
    ): JsonResponse {
        $organization->setName($payload->name);

        $em->persist($organization);
        $em->flush();

        return $this->json(new OrganizationResponseDTO($organization), JsonResponse::HTTP_OK);
    }

    #[Route('/api/organizations/{id}', name: 'app_organization_show', methods: ['GET'])]
    public function show(Organization $organization): JsonResponse
    {
        return $this->json(new OrganizationResponseDTO($organization), JsonResponse::HTTP_OK);
    }
}
