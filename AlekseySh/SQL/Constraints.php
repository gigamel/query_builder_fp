<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL;

class Constraints implements ConstraintsInterface
{
    /**
     * @param array $values
     */
    public function __construct(protected readonly array $values)
    {
    }
    
    /**
     * @inheritDoc
     */
    public function hasBadValue(array $values): bool
    {
        foreach ($values as $value) {
            if (is_array($value) && $this->hasBadValue($value)) {
                return true;
            }
            
            if (in_array($value, $this->values, true)) {
                return true;
            }
        }
        
        return false;
    }
}
