<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\DataStructure\MetadataSource;

use Infotech\DocumentGenerator\DataSource\FetcherInterface;
use Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface;

abstract class MetadataFetcher implements FetcherInterface
{
    /**
     * @var StructureDefinitionInterface
     */
    private $structure;

    public function __construct(StructureDefinitionInterface $structure)
    {
        $this->structure = $structure;
    }


    /**
     * @return \Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Get placeholder substitutions from origin
     *
     * @param mixed $origin original data or identifier to fetch strings
     *
     * @return array Placeholders to data strings map
     */
    public function getData($origin)
    {
        return array_reduce(
            $this->structure->getChildren(),
            function ($acc, $childDef) {
                return array_merge($acc, array($childDef['name'] => $childDef['name']));
            },
            $this->getMetadataValues()
        );
    }

    /**
     * @return array
     */
    abstract public function getMetadataValues();
}
