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
use Infotech\DocumentGenerator\DataSource\SourceInterface;
use Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface;
use Infotech\DocumentGenerator\DataStructure\StructurePool;

abstract class MetadataSource implements SourceInterface
{

    /**
     * @var StructurePool
     */
    private $structures;

    public function __construct(StructurePool $structures)
    {
        $this->structures = $structures;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchData($fetcherName, $originData)
    {
        return $this->createFetcher($this->structures[$fetcherName])->getData($originData);
    }

    /**
     * @param StructureDefinitionInterface $structure
     *
     * @return FetcherInterface
     */
    abstract public function createFetcher(StructureDefinitionInterface $structure);
}
