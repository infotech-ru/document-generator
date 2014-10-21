<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\DataStructure\Definition;

use Infotech\DocumentGenerator\DataStructure\Definition\Exception\InvalidDefinitionException;

/**
 * Common Document structure
 */
class CommonDocument extends CommonStructureDefinition implements DocumentInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param array $name
     * @param array $fields
     * @param array $structures
     *
     * @throws InvalidDefinitionException if name is empty
     */
    public function __construct($name, array $fields, array $structures)
    {
        parent::__construct($fields, $structures);
        $this->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set document name
     *
     * @param string $name
     *
     * @throws InvalidDefinitionException if name is empty
     */
    public function setName($name)
    {
        if (!$name) {
            throw new InvalidDefinitionException('Document name can not be empty string');
        }

        $this->name = $name;
    }
}
