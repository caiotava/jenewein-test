<?php

namespace App\Tests\Models;

use DateTimeImmutable;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;
use App\Entity\Organization;
use App\Model\OrganizationResponseDTO;

class OrganizationResponseDTOTest extends TestCase
{
    public function testFromList(): void
    {
        $newOrganization = function (int $id, string $name, DateTimeImmutable $createdAt) {
            $organization = new Organization();
            $organization->setName($name);

            $ref = new ReflectionProperty($organization::class, 'id');
            $ref->setAccessible(true);
            $ref->setValue($organization, $id);

            $refCreatedAt = new ReflectionProperty($organization::class, 'createdAt');
            $refCreatedAt->setAccessible(true);
            $refCreatedAt->setValue($organization, $createdAt);

            return $organization;
        };

        $createdAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00');
        $organizations = [
            $newOrganization(1, 'organization 1', $createdAt),
            $newOrganization(2, 'organization 2', $createdAt),
        ];

        $this->assertEquals(
            [
                new OrganizationResponseDTO($organizations[0]),
                new OrganizationResponseDTO($organizations[1]),
            ],
            OrganizationResponseDTO::fromList($organizations),
        );
    }
}
