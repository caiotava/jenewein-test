<?php

namespace App\Model;

use App\Entity\CourseContent;

readonly class ContentResponseDTO
{
    public string $id;
    public string $title;
    public string $description;
    public string $link;

    public function __construct(CourseContent $content)
    {
        $this->id = $content->getId();
        $this->title = $content->getTitle();
        $this->description = $content->getDescription();
        $this->link = $content->getLink();
    }
}
