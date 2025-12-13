<?php

namespace App\Service;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator
{
    public function paginate(QueryBuilder $queryBuilder, int $page = 1, ?int $limit = 20): array
    {
        if (!is_int($limit) || $limit < 1) {
            $limit = 20;
        }

        $offset = ($page - 1) * $limit;
        $queryBuilder->setMaxResults($limit)->setFirstResult($offset);

        $paginator = new DoctrinePaginator($queryBuilder);
        $total = $paginator->count();

        return [
            'items' => iterator_to_array($paginator),
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
            'pages_total' => ($total / $limit),
        ];
    }
}
