<?php

namespace App\Model;

use App\Entity\Organization;

readonly class OrganizationResponseDTO
{
    public int $id;
    public string $name;

    public function __construct(Organization $organization)
    {
        $this->id = $organization->getId();
        $this->name = $organization->getName();
    }

    /**
     * @param Organization[] $organizations
     * @return OrganizationResponseDTO[]
     */
    public static function fromList(array $organizations): array
    {
        $result = [];
        foreach ($organizations as $organization) {
            $result[] = new self($organization);
        }

        return $result;
    }
}
