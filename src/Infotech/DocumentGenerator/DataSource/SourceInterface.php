<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\DataSource;

/**
 * Data source interface
 */
interface SourceInterface
{
    /**
     * Returns fetcher for certain data structure
     *
     * @param string $fetcherName
     *
     * @param mixed $originData
     *
     * @return array
     */
    public function fetchData($fetcherName, $originData);
} 
