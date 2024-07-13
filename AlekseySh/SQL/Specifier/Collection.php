<?php

declare(strict_types=1);

namespace FpDbTest\AlekseySh\SQL\Specifier;

use Exception;
use FpDbTest\AlekseySh\SQL\Specifier\Resolver\PlacemarkResolver;

class Collection implements CollectionInterface
{
    protected const array SUPPORTED_PLACEMARKS = ['?', ':'];
    
    protected readonly string $placemark;
    
    protected array $collection = [];
    
    /**
     * @param string $placemark
     * @param ResolverInterface|null $placemarkResolver
     * @param ResolverInterface[] $resolvers
     *
     * @throws Exception
     */
    public function __construct(
        string $placemark = '?',
        ?ResolverInterface $placemarkResolver = null,
        array $resolvers = []
    ) {
        if (!in_array($placemark, self::SUPPORTED_PLACEMARKS, true)) {
            throw new Exception(
                sprintf(
                    'Unsupported [%s] placemark. Value should be of choices [%s]',
                    $placemark,
                    implode(', ', self::SUPPORTED_PLACEMARKS)
                )
            );
        }
        
        $this->placemark = $placemark;
        
        $this->collection[''] = $placemarkResolver ?? new PlacemarkResolver();
        
        foreach ($resolvers as $specifier => $resolver) {
            $this->register($specifier, $resolver);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function register(string $specifier, ResolverInterface $resolver): void
    {
        if (array_key_exists($specifier, $this->collection)) {
            throw new Exception(sprintf('Specifier [%s] already registered', $specifier));
        }
        
        $this->collection[$specifier] = $resolver;
    }
    
    /**
     * @inheritDoc
     */
    public function get(string $specifier): ResolverInterface
    {
        if (empty($specifier)) {
            throw new Exception('Specifier should not be empty');
        }
        
        $normalizedSpecifier = substr($specifier, 1);
        if (array_key_exists($normalizedSpecifier, $this->collection)) {
            return $this->collection[$normalizedSpecifier];
        }
        
        throw new Exception(sprintf('Unknown specifier [%s]', $specifier));
    }
    
    /**
     * @inheritDoc
     */
    public function getSpecifiers(): array
    {
        return $this->collection;
    }
    
    /**
     * @inheritDoc
     */
    public function getPlacemark(): string
    {
        return $this->placemark;
    }
}
