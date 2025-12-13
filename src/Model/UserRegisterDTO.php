<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\ContentLevel;

class UserRegisterDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\NoSuspiciousCharacters]
        #[Assert\Length(min: 1, max: 255)]
        public $name,

        #[Assert\NotBlank]
        #[Assert\Email]
        #[Assert\Length(max: 255)]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        public string $password,

        #[Assert\Choice(choices: ['ROLE_USER'])]
        public string $role,

        public int|null $organizationID,
    )
    {
    }
}
