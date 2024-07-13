<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier;

use Exception;

interface CollectionInterface
{
    /**
     * @param string $specifier
     * @param ResolverInterface $resolver
     *
     * @return void
     *
     * @throws Exception
     */
    public function register(string $specifier, ResolverInterface $resolver): void;
    
    /**
     * @param string $specifier
     *
     * @return ResolverInterface
     *
     * @throws Exception
     */
    public function get(string $specifier): ResolverInterface;
    
    /**
     * @return ResolverInterface[]
     */
    public function getSpecifiers(): array;
    
    /**
     * @return string
     */
    public function getPlacemark(): string;
}
