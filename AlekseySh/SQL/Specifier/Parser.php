<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier;

class Parser implements ParserInterface
{
    protected const string SPECIAL_PLACEMARK = '?';
    
    /**
     * @inheritDoc
     */
    public function parseSpecifiers(CollectionInterface $collection, string $query): array
    {
        preg_match_all($this->buildRegex($collection), $query, $matches, PREG_OFFSET_CAPTURE);
        return $matches[0] ?? [];
    }
    
    /**
     * @param CollectionInterface $collection
     *
     * @return string
     */
    protected function buildRegex(CollectionInterface $collection): string
    {
        return sprintf(
            '(%s[%s]?)',
            (self::SPECIAL_PLACEMARK === $collection->getPlacemark() ? '\\' : '') . $collection->getPlacemark(),
            implode('', array_keys($collection->getSpecifiers()))
        );
    }
}
