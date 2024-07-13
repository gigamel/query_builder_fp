<?php

declare(strict_types=1);

namespace FpDbTest;

use Exception;

interface QueryBuilderInterface
{
    /**
     * @param string $query
     * @param array $args
     *
     * @return string
     *
     * @throws Exception
     */
    public function build(string $query, array $args = []): string;
}
