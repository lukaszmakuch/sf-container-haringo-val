<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\ValueSource\ValueSource;

/**
 * Represents a value stored within the container.
 * 
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 */
class InjectedValue implements ValueSource
{
    private $keyFromContainer;
    
    /**
     * Sets the key of value stored within the container.
     * 
     * @param String $keyFromContainer
     */
    public function __construct($keyFromContainer)
    {
        $this->keyFromContainer = $keyFromContainer;
    }
    
    /**
     * Gets the previously given key from container.
     * 
     * @return String 
     */
    public function getKeyFromContainer()
    {
        return $this->keyFromContainer;
    }
}
