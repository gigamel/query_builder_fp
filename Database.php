<?php

declare(strict_types=1);

namespace FpDbTest;

use Exception;
use mysqli;

class Database implements DatabaseInterface
{
    /**
     * @param mysqli $mysqli
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(
        private mysqli $mysqli,
        private readonly QueryBuilderInterface $queryBuilder
    ) {
    }

    /**
     * @param string $query
     * @param array $args
     *
     * @return string
     *
     * @throws Exception
     */
    public function buildQuery(string $query, array $args = []): string
    {
        return $this->queryBuilder->build($query, $args);
    }

    /**
     * @return mixed
     */
    public function skip(): mixed
    {
        return 1000000000000;
    }
}
