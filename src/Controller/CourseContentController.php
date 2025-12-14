<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CourseContent;
use App\Entity\User;
use App\Model\ContentRequestDTO;
use App\Model\ContentResponseDTO;
use App\Repository\CourseContentRepository;
use App\Repository\CourseRepository;
use App\Security\Role;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CourseContentController extends AbstractController
{
    public function __construct(
        private readonly CourseContentRepository $contentRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly Paginator $paginator,
    ) {
    }

    #[Route('/api/courses/{course}/contents', name: 'app_courses_contents', methods: ['GET'])]
    #[IsGranted(Role::USER->value)]
    public function list(Course $course, Request $request): JsonResponse
    {
        $queryBuilder = $this->contentRepository->createQueryBuilder('c')
            ->andWhere('c.course = :val')
            ->setParameter('val', $course)
            ->addOrderBy('c.id', 'ASC');

        $pagination = $this->paginator->paginate($queryBuilder, $request);
        $contents = $pagination->convertItemsToDTO(ContentResponseDTO::class);

        return $this->json($contents);
    }

    #[Route('/api/courses/{id}/contents', name: 'app_create_contents', methods: ['POST'])]
    #[IsGranted(Role::CONTENT_MANAGER->value)]
    public function create(
        #[CurrentUser] User $user,
        Course $course,
        #[MapRequestPayload] ContentRequestDTO $payload,
    ): JsonResponse {
        $hasSameOrganization = $user->getOrganization()?->getId() === $course->getOrganization()->getId();

        if (!$hasSameOrganization && !$user->hasRole(Role::ADMIN)) {
            throw $this->createAccessDeniedException();
        }

        $content = new CourseContent();
        $content->setCourse($course);
        $content->setTitle($payload->title);
        $content->setDescription($payload->description);
        $content->setLink($payload->link);

        $this->entityManager->persist($content);
        $this->entityManager->flush();

        return $this->json(new ContentResponseDTO($content), Response::HTTP_CREATED);
    }
}
