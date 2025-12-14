<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    use TimestampEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: 'courses')]
    private Organization $organization;

    /**
     * @var Collection<int, UserCourse>
     */
    #[ORM\OneToMany(targetEntity: UserCourse::class, mappedBy: 'course', orphanRemoval: true)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection<int, UserCourse>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserCourse $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCourse($this);
        }

        return $this;
    }

    public function removeUser(UserCourse $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCourse() === $this) {
                $user->setCourse(null);
            }
        }

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
}
