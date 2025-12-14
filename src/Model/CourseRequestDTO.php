<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CourseRequestDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $description,
        #[Assert\NotBlank]
        public int $organization_id,
    ) {
    }
}
