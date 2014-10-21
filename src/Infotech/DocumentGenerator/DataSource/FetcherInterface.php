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

use Infotech\DocumentGenerator\DataSource\Exception\DataNotFoundException;

interface FetcherInterface
{
    /**
     * Get placeholder substitutions from origin
     *
     * @param mixed $origin original data or identifier for strings fetching
     *
     * @return array Placeholders to data strings map,
     *
     * @throws DataNotFoundException if can't find data associated with specified key
     */
    public function getData($origin);
}
