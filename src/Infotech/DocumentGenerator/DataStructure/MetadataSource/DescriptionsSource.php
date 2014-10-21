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

use Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface;

class DescriptionsSource extends MetadataSource
{
    /**
     * {@inheritdoc}
     */
    public function createFetcher(StructureDefinitionInterface $structure)
    {
        return new DescriptionsFetcher($structure);
    }
}
