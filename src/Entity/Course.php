<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Course
{
    use TimestampEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: 'courses')]
    private Organization $organization;

    /**
     * @var Collection<int, UserCourse>
     */
    #[ORM\OneToMany(targetEntity: UserCourse::class, mappedBy: 'course', orphanRemoval: true)]
    private Collection $users;

    /**
     * @var Collection<int, CourseContent>
     */
    #[ORM\OneToMany(targetEntity: CourseContent::class, mappedBy: 'course')]
    private Collection $courseContents;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->courseContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return Collection<int, CourseContent>
     */
    public function getCourseContents(): Collection
    {
        return $this->courseContents;
    }
}
