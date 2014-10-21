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

use Infotech\DocumentGenerator\DataStructure\Definition\Exception\DefinitionDuplicateException;
use Infotech\DocumentGenerator\DataStructure\Definition\Exception\InvalidDefinitionException;

class CommonStructureDefinition implements StructureDefinitionInterface
{
    private $placeholders = array();
    private $children = array();

    /**
     * @param array $fields      {@see addPlaceholders()}
     * @param array $structures  {@see addChildren()}
     *
     * @throws DefinitionDuplicateException if fields or structures has names conflicts of definitions
     * @throws InvalidDefinitionException   if any definition of field or structure is malformed
     */
    public function __construct(array $fields, array $structures)
    {
        $this->addPlaceholders($fields);
        $this->addChildren($structures);
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaceholders()
    {
        return $this->placeholders;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPlaceholders()
    {
        return (boolean)$this->placeholders;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return array_values($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function hasChildren()
    {
        return (boolean)$this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function getSamples()
    {
        return $this->getMetadataMap('sample');
    }

    /**
     * {@inheritdoc}
     */
    public function getEmptyValues()
    {
        return $this->getMetadataMap('empty');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptions()
    {
        return $this->getMetadataMap('description');
    }

    /**
     * Add placeholder definition to structure
     *
     * @param string $placeholder
     * @param string $description
     * @param string $sampleValue
     * @param string $emptyValue
     *
     * @throws DefinitionDuplicateException if new definition conflicts with existing one
     */
    public function addPlaceholder($placeholder, $description, $sampleValue, $emptyValue)
    {
        if (isset($this->placeholders[$placeholder])) {
            throw new DefinitionDuplicateException(
                sprintf('Field with same placeholder "%s" already exists in structure', $placeholder)
            );
        }

        $this->placeholders[$placeholder] = array(
            'placeholder' => $placeholder,
            'description' => $description,
            'sample' => $sampleValue,
            'empty' => $emptyValue,
        );
    }

    /**
     * Add linked structure definition
     *
     * @param string $structureName
     * @param string $prefix
     * @param string $suffix
     *
     * @throws DefinitionDuplicateException if new definition conflicts with existing one
     */
    public function addChild($structureName, $prefix = '', $suffix = '')
    {
        if (isset($this->children[$structureName])) {
            throw new DefinitionDuplicateException(
                sprintf('Child structure with same name "%s" already exists', $structureName)
            );
        }

        $this->children[$structureName] = array(
            'name' => $structureName,
            'prefix' => (string)$prefix,
            'suffix' => (string)$suffix
        );
    }

    private function getArrayValue(array $field, $parameter, $default = null)
    {
        $value = isset($field[$parameter]) ? $field[$parameter] : $default;

        if (null === $value) {
            throw new InvalidDefinitionException(sprintf('Definition parameter "%s" must be set', $parameter));
        }

        return $value;
    }

    /**
     * @param array $fields Fields definitions.
     *     <code>
     *     [
     *         [
     *             'placeholder' => string,
     *             'description' => string,
     *             'sample' => string,
     *             'empty' => string opt
     *         ],
     *         ...
     *     ]
     *     </code>
     *
     * @throws DefinitionDuplicateException if definition with same placeholder's name already exists
     * @throws InvalidDefinitionException if definition malformed
     */
    public function addPlaceholders(array $fields)
    {
        foreach ($fields as $placeholder => $fieldDef) {
            if (!is_array($fieldDef)) {
                throw new InvalidDefinitionException(
                    sprintf('Invalid definition of field "%s". Definition should be an array', $placeholder)
                );
            }

            try {
                $description = $this->getArrayValue($fieldDef, 'description');
                $sampleValue = $this->getArrayValue($fieldDef, 'sample');
                $emptyValue = $this->getArrayValue($fieldDef, 'empty', '');
                $placeholder = is_string($placeholder) ? $placeholder : $this->getArrayValue($fieldDef, 'placeholder');
            } catch (InvalidDefinitionException $e) {
                throw new InvalidDefinitionException(
                    sprintf('Invalid definition of field "%s". %s', $placeholder, $e->getMessage())
                );
            }

            $this->addPlaceholder($placeholder, $description, $sampleValue, $emptyValue);
        }
    }

    /**
     * @param array $structures Child structures.
     *     <code>
     *     [
     *         [
     *             'name' => string,
     *             'prefix' => string opt,
     *             'suffix' => string opt
     *         ],
     *         ...
     *     ]
     *     </code>
     *
     * @throws DefinitionDuplicateException if definition with same structure's name already exists
     * @throws InvalidDefinitionException if definition malformed
     */
    public function addChildren(array $structures)
    {
        foreach ($structures as $structureName => $structureDef) {
            if (is_int($structureName) && is_string($structureDef)) {
                $structureName = $structureDef;
                $structureDef = array();
            }

            if (!is_array($structureDef)) {
                throw new InvalidDefinitionException(
                    sprintf('Invalid definition of child structure "%s". Definition should be an array', $structureName)
                );
            }

            try {
                $prefix = $this->getArrayValue($structureDef, 'prefix', '');
                $suffix = $this->getArrayValue($structureDef, 'suffix', '');
                $structureName = is_string($structureName)
                    ? $structureName
                    : $this->getArrayValue($structureDef, 'name');
            } catch (InvalidDefinitionException $e) {
                throw new InvalidDefinitionException(
                    sprintf('Invalid definition of child structure "%s". %s', $structureName, $e->getMessage())
                );
            }

            $this->addChild($structureName, $prefix, $suffix);
        }
    }

    /**
     * @param string $metadata
     *
     * @return array [<placeholder> => <metadata value>]
     */
    private function getMetadataMap($metadata)
    {
        return array_reduce(
            $this->placeholders,
            function (array $acc, $definition) use ($metadata) {
                return array_merge($acc, array($definition['placeholder'] => $definition[$metadata]));
            },
            array()
        );
    }
}
