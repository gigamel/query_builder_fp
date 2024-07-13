<?php

declare(strict_types=1);

namespace FpDbTest;

use FpDbTest\AlekseySh\SQL\QueryBuilder;

final class QueryBulderAdapter implements QueryBuilderInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(private QueryBuilder $queryBuilder)
    {
    }
    
    /**
     * @inheritDoc
     */
    public function build(string $query, array $args = []): string
    {
        return $this->queryBuilder->build($query, $args);
    }
}
