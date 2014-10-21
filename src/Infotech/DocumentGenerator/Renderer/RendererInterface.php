<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\Renderer;

interface RendererInterface
{
    /**
     * Render template with data.
     *
     * @param string $templatePath  Template file
     * @param array  $data          Associative array [<placeholder> => <substitution>, ...]
     *
     * @return string Rendered document as binary string
     */
    function render($templatePath, array $data);
} 
