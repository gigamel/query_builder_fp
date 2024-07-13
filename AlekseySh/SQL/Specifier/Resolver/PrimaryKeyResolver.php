<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier\Resolver;

use Exception;
use FpDbTest\AlekseySh\SQL\Specifier\ResolverInterface;

class PrimaryKeyResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(mixed $value): string
    {
        if (is_array($value)) {
            return '`' . implode('`, `', $value) . '`';
        }
        
        if (is_string($value)) {
            return '`' . $value . '`';
        }
        
        throw new Exception('Invalid primary key value');
    }
}
