<?php

namespace Infotech\DocumentGenerator\Util;

use InvalidArgumentException;
use ReflectionObject;

class PropertyAccess
{
    /**
     * @param object|array $objectOrArray
     * @param string       $propertyName
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get($objectOrArray, $propertyName)
    {
        if (is_array($objectOrArray)) {
            return $objectOrArray[$propertyName];
        } elseif (is_object($objectOrArray)) {
            $refObject = new ReflectionObject($objectOrArray);
            if ($refObject->hasProperty($propertyName)
                    and $refProp = $refObject->getProperty($propertyName)
                    and $refProp->isPublic()) {
                return $refProp->getValue($objectOrArray);
            }
            $getter = 'get' . $propertyName;
            if ($refObject->hasMethod($getter)) {
                return $refObject->getMethod($getter)->invoke($objectOrArray);
            }
        }

        throw new InvalidArgumentException(
            sprintf('Can not read property "%s"', $propertyName)
        );
    }
}
