<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\ValueSourceMapper\ValueSourceArrayMapper;
use lukaszmakuch\Haringo\Mapper\Exception\ImpossibleToBuildFromArray;
use lukaszmakuch\Haringo\Mapper\Exception\ImpossibleToMapObject;

/**
 * Maps injected values to arrays and from arrays to objects.
 * 
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 */
class InjectedValueMapper implements ValueSourceArrayMapper
{
    private static $MAPPED_KEY_CONTAINER_KEY = 0;
    
    public function mapToArray($objectToMap)
    {
        if (!($objectToMap instanceof InjectedValue)) {
            throw new ImpossibleToMapObject();
        }
        
        return [
            self::$MAPPED_KEY_CONTAINER_KEY => $objectToMap->getKeyFromContainer()
        ];
    }

    public function mapToObject(array $previouslyMappedObject)
    {
        if (!isset($previouslyMappedObject[self::$MAPPED_KEY_CONTAINER_KEY])) {
            throw new ImpossibleToBuildFromArray();
        }
        
        $keyFromContainer = $previouslyMappedObject[self::$MAPPED_KEY_CONTAINER_KEY];
        return new InjectedValue($keyFromContainer);
    }
}