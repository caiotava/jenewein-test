<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserRegisterDTO
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\NoSuspiciousCharacters] #[Assert\Length(min: 1, max: 255)]
        public string $name,
        #[Assert\NotBlank] #[Assert\Email] #[Assert\Length(max: 255)]
        public string $email,
        #[Assert\NotBlank] #[Assert\Length(min: 8)]
        public string $password,
        #[Assert\Choice(choices: ['ROLE_USER', 'ROLE_CONTENT_MANAGER', 'ROLE_SUPER_ADMIN'])]
        public string $role,
        public int|null $organizationID,
    ) {
    }
}
