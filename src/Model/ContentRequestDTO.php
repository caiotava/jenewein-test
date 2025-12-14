<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ContentRequestDTO
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(max: 255)]
        public string $title,
        #[Assert\NotBlank]
        public string $description,
        #[Assert\NotBlank] #[Assert\Url]
        public string $link,
    ) {
    }
}
