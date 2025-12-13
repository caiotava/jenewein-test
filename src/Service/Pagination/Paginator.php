<?php

namespace App\Service\Pagination;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    public const int DEFAULT_LIMIT = 20;

    public function paginate(QueryBuilder $queryBuilder, Request $request): PaginateResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);
        if ($limit < 1) {
            $limit = self::DEFAULT_LIMIT;
        }

        $offset = ($page - 1) * $limit;
        $queryBuilder->setMaxResults($limit)->setFirstResult($offset);

        $paginator = new DoctrinePaginator($queryBuilder);
        $total = $paginator->count();
        $totalPages = max(0, ceil($total / $limit));

        return new PaginateResponse(
            iterator_to_array($paginator),
            $limit,
            $page,
            $total,
            ($total / $limit),
        );
    }
}
