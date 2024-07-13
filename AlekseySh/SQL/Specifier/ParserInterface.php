<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier;

interface ParserInterface
{
    /**
     * @param CollectionInterface
     * @param string $query
     *
     * @return array
     */
    public function parseSpecifiers(CollectionInterface $collection, string $query): array;
}
