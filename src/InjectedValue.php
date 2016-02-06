<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\ValueSource\ValueSource;

class InjectedValue implements ValueSource
{
    private $keyFromContainer;
    
    public function __construct($keyFromContainer)
    {
        $this->keyFromContainer = $keyFromContainer;
    }
    
    public function getKeyFromContainer()
    {
        return $this->keyFromContainer;
    }
}
