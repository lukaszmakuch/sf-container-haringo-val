<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\Builder\Extension\ValueSourceExtension;
use lukaszmakuch\Haringo\ValueSourceMapper\ValueSourceArrayMapper;
use lukaszmakuch\Haringo\ValueSourceResolver\ValueResolver;

/**
 * Allows to use values from the Symfony dependency injection container.
 * 
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 */
class InjectedValueExtension implements ValueSourceExtension
{
    private $mapper;
    private $resolver;
    
    /**
     * Provides dependencies.
     * 
     * @param ValueSourceArrayMapper $mapper used to map value sources
     * @param ValueResolver $resolver used to read values from the container
     */
    public function __construct(
        ValueSourceArrayMapper $mapper,
        ValueResolver $resolver
    ) {
        $this->mapper = $mapper;
        $this->resolver = $resolver;
    }
    
    public function getMapper()
    {
        return $this->mapper;
    }

    public function getResolver()
    {
        return $this->resolver;
    }

    public function getSupportedValueSourceClass()
    {
        return InjectedValue::class;
    }

    public function getUniqueExtensionId()
    {
        return "lukaszmakuch.sf_container_haringo_val";
    }
}
