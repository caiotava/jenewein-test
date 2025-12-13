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
}
