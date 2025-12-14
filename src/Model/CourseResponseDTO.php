<?php

namespace App\Model;

use App\Entity\Course;

readonly class CourseResponseDTO
{
    public int $id;
    public string $name;
    public string $description;

    public function __construct(Course $course)
    {
        $this->id = $course->getId();
        $this->name = $course->getName();
        $this->description = $course->getDescription();
    }
}
