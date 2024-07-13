<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier;

use Exception;

interface ResolverInterface
{
    /**
     * @param mixed $value
     *
     * @return string
     *
     * @throws Exception
     */
    public function resolve(mixed $value): string;
}
