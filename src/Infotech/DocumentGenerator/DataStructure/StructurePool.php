<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\DataStructure;

use Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface;
use ArrayObject;
use InvalidArgumentException;

class StructurePool extends ArrayObject
{
    /**
     * @param mixed $name
     * @param mixed $structureDefinition
     */
    public function offsetSet($name, $structureDefinition)
    {
        if (!$structureDefinition instanceof StructureDefinitionInterface) {
            throw new InvalidArgumentException(
                'Structure should implements Infotech\DocumentGenerator\DataStructure\StructureDefinitionInterface'
            );
        }
        if ($this->offsetExists($name)) {
            throw new InvalidArgumentException(sprintf('Structure named "%s" already registered', $name));
        }
        parent::offsetSet($name, $structureDefinition);
    }
}
