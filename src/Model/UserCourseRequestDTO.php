<?php

namespace App\Model;

use App\Entity\ContentLevel;
use Symfony\Component\Validator\Constraints as Assert;

class UserCourseRequestDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Choice(choices: [
            ContentLevel::BEGINNER->value,
            ContentLevel::INTERMEDIATE->value,
            ContentLevel::ADVANCED->value,
        ])]
        public string $content_level
    ) {
    }
}
