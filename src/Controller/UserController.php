<?php

namespace App\Controller;

use App\Entity\ContentLevel;
use App\Entity\Course;
use App\Entity\User;
use App\Entity\UserCourse;
use App\Model\CourseResponseDTO;
use App\Model\UserCourseRequestDTO;
use App\Repository\CourseRepository;
use App\Repository\UserCourseRepository;
use App\Service\Pagination\Paginator;
use App\Security\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly CourseRepository $courseRepository,
        private readonly UserCourseRepository $userCourseRepository,
        private readonly Paginator $paginator,
    ) {
    }

    #[Route('/api/users/{id}/courses', name: 'app_users_courses', methods: ['GET'])]
    #[IsGranted(Role::USER->value)]
    public function courses(int $id, #[CurrentUser] User $user, Request $request): JsonResponse
    {
        $queryBuilder = $this->courseRepository->accessibleUserCourses($id, $user);
        $pagination = $this->paginator->paginate($queryBuilder, $request);

        $courses = $pagination->convertItemsToDTO(CourseResponseDTO::class);

        return $this->json($courses);
    }

    #[Route('/api/users/{user}/courses/{course}', name: 'app_users_add_course', methods: ['PUT'])]
    #[IsGranted(Role::USER->value)]
    public function addCourse(
        #[CurrentUser] User $userAuth,
        #[MapRequestPayload] UserCourseRequestDTO $payload,
        User $user,
        Course $course,
        EntityManagerInterface $em
    ): Response {
        if ($user->getId() !== $userAuth->getId() && !$userAuth->hasRole(Role::CONTENT_MANAGER)) {
            throw $this->createAccessDeniedException();
        }

        if ($user->getOrganization()->getId() !== $course->getOrganization()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $userCourse = $this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course]);
        if (is_null($userCourse)) {
            $userCourse = new UserCourse();
            $userCourse->setUser($user);
            $userCourse->setCourse($course);
        }

        $userCourse->setContentLevel(ContentLevel::tryFrom($payload->content_level));

        $em->persist($userCourse);
        $em->flush();

        return new Response(null, Response::HTTP_CREATED);
    }
}
