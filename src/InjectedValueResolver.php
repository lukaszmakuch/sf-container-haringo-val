<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\ValueSource\ValueSource;
use lukaszmakuch\Haringo\ValueSourceResolver\ValueResolver;
use Symfony\Component\DependencyInjection\Container;

class InjectedValueResolver implements ValueResolver
{
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function resolveValueFrom(ValueSource $source)
    {
        /* @var $source InjectedValue */
        $keyFromContainer = $source->getKeyFromContainer();
        $valueFromContainer = $this->container->get($keyFromContainer);
        return $valueFromContainer;
    }

}