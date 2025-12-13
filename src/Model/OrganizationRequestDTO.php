<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class OrganizationRequestDTO
{
    public function __construct(
        public ?int $id,
        #[Assert\NotBlank] #[Assert\NoSuspiciousCharacters]
        public string $name,
    ) {
    }
}
