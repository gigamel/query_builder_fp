<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL;

use Exception;
use FpDbTest\AlekseySh\SQL\ConditionalBlock\Parser as ConditionalBlockParser;
use FpDbTest\AlekseySh\SQL\ConditionalBlock\ParserInterface as ConditionalBlockParserInterface;
use FpDbTest\AlekseySh\SQL\Specifier\CollectionInterface as SpecifierCollectionInterface;
use FpDbTest\AlekseySh\SQL\Specifier\Parser as SpecifierParser;
use FpDbTest\AlekseySh\SQL\Specifier\ParserInterface as SpecifierParserInterface;

class QueryBuilder
{
    protected readonly ConditionalBlockParserInterface $conditionalBlockParser;
    
    protected readonly SpecifierParserInterface $specifierParser;
    
    /**
     * @param SpecifierCollectionInterface $specifierCollection
     * @param ConditionalBlockParserInterface|null $conditionalBlockParser
     * @param SpecifierParserInterface|null $specifierParser
     *
     * @throws Exception
     */
    public function __construct(
        protected readonly SpecifierCollectionInterface $specifierCollection,
        ?ConditionalBlockParserInterface $conditionalBlockParser = null,
        ?SpecifierParserInterface $specifierParser = null,
    ) {
        $this->conditionalBlockParser = $conditionalBlockParser ?? new ConditionalBlockParser();
        $this->specifierParser = $specifierParser ?? new SpecifierParser();
    }
    
    /**
     * @param string $query
     * @param array $args
     *
     * @return string
     *
     * @throws Exception
     */
    public function build(string $query, array $args = []): string
    {
        foreach ($this->conditionalBlockParser->parseBlocks($query) as $conditionalBlock) {
            $specifiers = $this->specifierParser->parseSpecifiers($this->specifierCollection, $conditionalBlock);
            
            $query = str_replace(
                $conditionalBlock,
                $this->conditionalBlockParser->normalizeBlock(
                    $this->replaceVars(
                        $conditionalBlock,
                        $specifiers,
                        array_splice($args, -count($specifiers))
                    )
                ),
                $query
            );
        }
        
        return trim(
            $this->replaceVars(
                $query,
                $this->specifierParser->parseSpecifiers($this->specifierCollection, $query),
                $args
            )
        );
    }
    
    /**
     * @param string $query
     * @param array $specifiers
     * @param array $args
     *
     * @return string
     *
     * @throws Exception
     */
    protected function replaceVars(string $query, array $specifiers, array $args): string
    {
        $queryLength = strlen($query);

        foreach ($specifiers as $index => $specifier) {
            $resolver = $this->specifierCollection->get($specifier[0]);
            
            $query = substr_replace(
                $query,
                $resolver->resolve($args[$index]),
                $specifier[1] + strlen($query) - $queryLength,
                strlen($specifier[0])
            );
        }
        
        return $query;
    }
}
