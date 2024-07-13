<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\ConditionalBlock;

use Exception;

interface ParserInterface
{
    /**
     * @param string $query
     *
     * @return array
     *
     * @throws Exception
     */
    public function parseBlocks(string $query): array;
    
    /**
     * @param string $block
     *
     * @return string
     */
    public function normalizeBlock(string $block): string;
}
