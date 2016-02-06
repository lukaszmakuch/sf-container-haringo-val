<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\SfContainerHaringoVal\InjectedValueExtension;
use lukaszmakuch\SfContainerHaringoVal\InjectedValueMapper;
use lukaszmakuch\SfContainerHaringoVal\InjectedValueResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Builds extension.
 * 
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 */
class InjectedValueExtensionFactory
{
    /**
     * Builds extension which uses the given container.
     * 
     * @param Container $container
     * @return InjectedValueExtension
     */
   public function buildWith(Container $container)
   {
        return new InjectedValueExtension(
            new InjectedValueMapper(),
            new InjectedValueResolver($container)
        );
   }
}
