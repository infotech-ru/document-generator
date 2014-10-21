<?php
/*
 * This file is part of the infotech/document-generator package.
 *
 * (c) Infotech, Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infotech\DocumentGenerator\DataStructure;

use Infotech\DocumentGenerator\DataSource\SourceInterface;
use Infotech\DocumentGenerator\Util\PropertyAccess;

/**
 * Structure Processor
 */
class StructureProcessor
{
    /**
     * @var SourceInterface
     */
    private $source;

    /**
     * @var StructurePool
     */
    private $structures;

    public function __construct(SourceInterface $source, StructurePool $structures)
    {
        $this->source = $source;
        $this->structures = $structures;
    }

    /**
     * Traverse structure tree and generate plain array of placeholder data.
     *
     * @param string $structureName
     * @param mixed  $origin
     *
     * @return array
     */
    public function process($structureName, $origin)
    {
        $def = $this->structures[$structureName];

        $data = array_merge(
            $def->getEmptyValues(),
            $this->source->fetchData($structureName, $origin)
        );

        $accessor = new PropertyAccess();

        foreach ($def->getChildren() as $childDef) {
            $data = array_merge(
                $data,
                $this->modifyPlaceholders(
                    $this->process($childDef['name'], $accessor->get($data, $childDef['name'])),
                    $childDef['prefix'],
                    $childDef['suffix']
                )
            );
            unset($data[$childDef['name']]);
        }

        return $data;
    }

    protected function modifyPlaceholders(array $data, $prefix, $suffix)
    {
        return array_combine(
            array_map(
                function ($placeholder) use ($prefix, $suffix) {
                    return $prefix . $placeholder . $suffix;
                },
                array_keys($data)
            ),
            $data
        );
    }
}
