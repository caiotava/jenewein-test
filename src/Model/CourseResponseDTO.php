<?php

namespace App\Model;

use App\Entity\Course;

readonly class CourseResponseDTO
{
    public readonly int $id;
    public readonly string $name;

    public function __construct(Course $course)
    {
        $this->id = $course->getId();
        $this->name = $course->getName();
    }
}
