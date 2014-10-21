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

interface StructureDefinitionInterface
{

    /**
     * Get placeholders definitions
     *
     * Each definition is an array with following structure:
     * <code>
     * [
     *   'placeholder' => string,
     *   'description' => string,
     *   'sample'      => string,
     *   'empty'       => string,
     * ]
     * </code>
     *
     * @return array
     */
    public function getPlaceholders();

    /**
     * Check if structure has own placeholders
     *
     * @return boolean
     */
    public function hasPlaceholders();

    /**
     * Get sample data set
     *
     * @return array [<placeholder> => <sample>, ...]
     */
    public function getSamples();

    /**
     * Get empty values set
     *
     * @return array [<placeholder> => <empty value>, ...]
     */
    public function getEmptyValues();

    /**
     * Get placeholders descriptions
     *
     * @return array [<placeholder> => <description>, ...]
     */
    public function getDescriptions();


    /**
     * Get linked structures
     *
     * Each child introduced by structure:
     * <code>
     * [
     *     'name' => string,
     *     'prefix' => string,
     *     'suffix' => string
     * ]
     * </code>
     *
     * @return array
     */
    public function getChildren();

    /**
     * Check if structure has linked structures
     *
     * @return boolean
     */
    public function hasChildren();
}
