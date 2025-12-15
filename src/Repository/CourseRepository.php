<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\User;
use App\Security\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function queryByOrganization(?int $organizationID): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c')->orderBy('c.id', 'ASC');

        if (!is_null($organizationID)) {
            $qb->andWhere('c.organization = :val')->setParameter('val', $organizationID);
        }

        return $qb;
    }

    public function accessibleUserCourses(int $userID, User $userRequesting): ?QueryBuilder
    {
        if ($userID != $userRequesting->getId() && !$userRequesting->isAdmin()) {
            $userID = $userRequesting->getId();
        }

        // Students: only enrolled courses
        return $this->createQueryBuilder('c')
            ->innerJoin('c.users', 'uc')
            ->andWhere('uc.user = :user')
            ->setParameter('user', $userID);
    }
}
