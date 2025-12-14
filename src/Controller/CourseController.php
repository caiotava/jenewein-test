<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\User;
use App\Model\CourseResponseDTO;
use App\Repository\CourseRepository;
use App\Security\Voter\CourseVoter;
use App\Service\Pagination\Paginator;
use App\Security\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CourseController extends AbstractController
{
    #[Route('/api/courses', name: 'app_courses_list', methods: ['GET'])]
    #[IsGranted(Role::CONTENT_MANAGER->value)]
    public function list(
        Request $request,
        CourseRepository $courseRepo,
        Paginator $paginator,
        #[CurrentUser] User $user,
    ): JsonResponse {
        $organizationID = $user->getOrganization()?->getId();
        if (!$user->hasRole(Role::ADMIN) && is_null($organizationID)) {
            throw $this->createAccessDeniedException();
        }

        $queryBuilder = $courseRepo->queryByOrganization($user->getOrganization()->getId());
        $result = $paginator->paginate($queryBuilder, $request);

        return $this->json($result->convertItemsToDTO(CourseResponseDTO::class));
    }

    #[Route('/api/courses/{id}', name: 'app_course_show', methods: ['GET'])]
    #[IsGranted(
        CourseVoter::VIEW,
        subject: 'course',
        message: 'Course not found',
        statusCode: Response::HTTP_NOT_FOUND,
    )]
    public function show(Course $course): JsonResponse
    {
        return $this->json(new CourseResponseDTO($course));
    }
}
