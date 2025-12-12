<?php

namespace App\Entity;

use App\Repository\UserCourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCourseRepository::class)]
class UserCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\Column(enumType: ContentLevel::class)]
    private ?ContentLevel $contentLevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getContentLevel(): ?ContentLevel
    {
        return $this->contentLevel;
    }

    public function setContentLevel(ContentLevel $contentLevel): static
    {
        $this->contentLevel = $contentLevel;

        return $this;
    }
}
