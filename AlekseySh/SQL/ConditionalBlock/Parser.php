<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\ConditionalBlock;

use Exception;

class Parser implements ParserInterface
{
    protected const string SPECIFIER = '%s';
    
    protected const string DEFAULT_LAYOUT = '{' . self::SPECIFIER . '}';
    
    protected readonly string $layout;
    
    protected readonly string $regex;
    
    protected readonly string $normalizeRegex;
    
    /**
     * @param string|null $layout
     *
     * @throws Exception
     */
    public function __construct(?string $layout = null)
    {
        $this->layout = trim($layout ?? self::DEFAULT_LAYOUT);
        if (false === strpos($this->layout, self::SPECIFIER)) {
            throw new Exception('Not found Layout placemark for parser conditional block');
        }
        
        $this->regex = sprintf('/(' . $this->layout . ')/U', '.*');
        $this->normalizeRegex = sprintf(
            '/[%s]/',
            implode(
                '',
                array_unique(
                    str_split(
                        str_replace(self::SPECIFIER, '', $this->layout)
                    )
                )
            )
        );
    }
    
    /**
     * @inheritDoc
     */
    public function parseBlocks(string $query): array
    {
        preg_match_all($this->regex, $query, $matches);
        return array_reverse(
            array_map(
                function ($block) {
                    if (preg_match($this->regex, substr($block, 1))) {
                        throw new Exception(
                            sprintf('Conditional block [%s] must not contain nested blocks', $block)
                        );
                    }
                    
                    return $block;
                },
                $matches[0] ?? []
            )
        );
    }
    
    /**
     * @inheritDoc
     */
    public function normalizeBlock(string $block): string
    {
        return sprintf(
            ' %s ',
            trim(preg_replace($this->normalizeRegex, '', $block))
        );
    }
}
