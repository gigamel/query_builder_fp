<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL;

interface ConstraintsInterface
{
    /**
     * @param array $values
     *
     * @return bool
     */
    public function hasBadValue(array $values): bool;
}
