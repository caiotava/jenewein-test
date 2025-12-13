<?php

namespace App\Controller;

use App\Model\CourseResponseDTO;
use App\Repository\CourseRepository;
use App\Service\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_CONTENT_MANAGER')]
final class CourseController extends AbstractController
{
    #[Route('/api/courses', name: 'app_courses_list', methods: ['GET'])]
    public function list(Request $request, CourseRepository $courseRepo, Paginator $paginator): JsonResponse
    {
        $queryBuilder = $courseRepo->createQueryBuilder('e')->orderBy('e.id', 'ASC');
        $result = $paginator->paginate($queryBuilder, $request);

        return $this->json($result->convertItemsToDTO(CourseResponseDTO::class));
    }
}
