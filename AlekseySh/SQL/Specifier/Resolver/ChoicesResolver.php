<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier\Resolver;

use Exception;
use FpDbTest\AlekseySh\SQL\Specifier\ResolverInterface;

class ChoicesResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(mixed $value): string
    {
        if (!is_array($value) || !$value) {
            throw new Exception('Invalid array value');
        }
        
        if (array_is_list($value)) {
            return implode(
                ', ',
                array_map(
                    function ($v) {
                        return $this->normalize($v);
                    },
                    $value
                )
            );
        }
        
        $normalized = [];
        foreach ($value as $k => $v) {
            if (!is_string($k)) {
                throw new Exception('Invalid key from array');
            }
            
            $normalized[] = sprintf('`%s` = %s', $k, $this->normalize($v));
        } // Todo
        
        return implode(', ', $normalized);
    }
    
    /**
     * @param mixed $arg
     *
     * @return string
     */
    private function normalize(mixed $arg): string // Todo
    {
        if (is_array($arg)) {
            return '`' . implode('`, `', $arg) . '`';
        }
        
        if (is_bool($arg)) {
            return $arg ? '1' : '0';
        }
        
        if (is_null($arg)) {
            return 'NULL';
        }
        
        if (is_string($arg)) {
            return sprintf("'%s'", $arg);
        }
        
        return (string) $arg;
    }
}
