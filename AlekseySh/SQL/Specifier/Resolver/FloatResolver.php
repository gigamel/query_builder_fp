<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier\Resolver;

use Exception;
use FpDbTest\AlekseySh\SQL\Specifier\ResolverInterface;

class FloatResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(mixed $value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }
        
        if (is_float($value)) {
            return (string) $value;
        }
        
        throw new Exception('Invalid float value');
    }
}
