<?php

namespace App\Service\Pagination;

readonly class PaginateResponse
{
    public function __construct(
        public array $items,
        public int $limit,
        public int $page,
        public int $total,
        public int $totalPages,
    ) {
    }

    public function convertItemsToDTO(string $classNameDTO): PaginateResponse
    {
        $itemsDTO = [];
        foreach ($this->items as $item) {
            $itemsDTO[] = new $classNameDTO($item);
        }

        return new PaginateResponse(
            $itemsDTO,
            $this->limit,
            $this->page,
            $this->total,
            $this->totalPages,
        );
    }
}
