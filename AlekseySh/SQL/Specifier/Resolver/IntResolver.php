<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier\Resolver;

use Exception;
use FpDbTest\AlekseySh\SQL\Specifier\ResolverInterface;

class IntResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(mixed $value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }
        
        if (is_int($value)) {
            return (string) $value;
        }
        
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        
        throw new Exception('Invalid int value');
    }
}
