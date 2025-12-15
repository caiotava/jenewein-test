<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Organization;
use App\Entity\User;
use App\Model\CourseRequestDTO;
use App\Model\CourseResponseDTO;
use App\Repository\CourseRepository;
use App\Security\Voter\CourseVoter;
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

        $queryBuilder = $courseRepo->queryByOrganization($organizationID);
        $result = $paginator->paginate($queryBuilder, $request);

        return $this->json($result->convertItemsToDTO(CourseResponseDTO::class));
    }

    #[Route('/api/courses/{id}', name: 'app_courses_show', methods: ['GET'])]
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

    #[Route('/api/courses', name: 'app_courses_create', methods: ['POST'])]
    #[IsGranted(Role::CONTENT_MANAGER->value)]
    public function create(
        #[CurrentUser] User $user,
        #[MapRequestPayload] CourseRequestDTO $payload,
        EntityManagerInterface $em
    ): JsonResponse {
        $organizationID = $payload->organization_id;
        if (!$user->hasRole(Role::ADMIN)) {
            $organizationID = $user->getOrganization()?->getId();
        }

        if (is_null($organizationID)) {
            return new JsonResponse(['message' => 'Organization id invalid'], Response::HTTP_BAD_REQUEST);
        }

        $organization = $em->getRepository(Organization::class)->find($organizationID);
        if (is_null($organization)) {
            return new JsonResponse(['message' => 'Organization id invalid'], Response::HTTP_BAD_REQUEST);
        }

        $course = new Course();
        $course->setName($payload->name);
        $course->setDescription($payload->description);
        $course->setOrganization($organization);

        $em->persist($course);
        $em->flush();

        return $this->json(new CourseResponseDTO($course), Response::HTTP_CREATED);
    }

    #[Route('/api/courses/{id}', name: 'app_courses_update', methods: ['PUT'])]
    #[IsGranted(CourseVoter::EDIT, subject: 'course')]
    public function update(
        #[MapRequestPayload] CourseRequestDTO $payload,
        Course $course,
        EntityManagerInterface $em
    ): JsonResponse {
        $course->setName($payload->name);
        $course->setDescription($payload->description);
        $em->persist($course);
        $em->flush();

        return $this->json(new CourseResponseDTO($course));
    }
}
