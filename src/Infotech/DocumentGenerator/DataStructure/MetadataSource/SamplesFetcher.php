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

class SamplesFetcher extends MetadataFetcher
{

    /**
     * @return array
     */
    public function getMetadataValues()
    {
        return $this->getStructure()->getSamples();
    }
}
