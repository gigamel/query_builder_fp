<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier\Resolver;

use FpDbTest\AlekseySh\SQL\Specifier\ResolverInterface;

class PlacemarkResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(mixed $value): string
    {
        if (is_array($value)) {
            return '`' . implode('`, `', $value) . '`';
        }
        
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        
        if (is_null($value)) {
            return 'NULL';
        }
        
        if (is_string($value)) {
            return sprintf("'%s'", $value);
        }
        
        return (string) $value;
    }
}
