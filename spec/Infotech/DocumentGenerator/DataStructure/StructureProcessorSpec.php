<?php

namespace spec\Infotech\DocumentGenerator\DataStructure;

use Infotech\DocumentGenerator\DataSource\SourceInterface;
use Infotech\DocumentGenerator\DataStructure\Definition\CommonStructureDefinition;
use Infotech\DocumentGenerator\DataStructure\StructurePool;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StructureProcessorSpec extends ObjectBehavior
{
    function it_is_initializable(SourceInterface $source, StructurePool $structures)
    {
        $this->beConstructedWith($source, $structures);
        $this->shouldHaveType('Infotech\DocumentGenerator\DataStructure\StructureProcessor');
    }

    function it_should_process_structure(SourceInterface $source)
    {
        $structure1 = new CommonStructureDefinition(
            array(
                array('placeholder' => 'sub1', 'description' => 'desc1', 'sample' => 'sample1'),
                array('placeholder' => 'sub2', 'description' => 'desc2', 'sample' => 'sample2'),
            ),
            array(
                array('name' => 'structure2', 'prefix' => 'pref1_', 'suffix' => '_suff1')
            )
        );
        $structure2 = new CommonStructureDefinition(
            array(
                array('placeholder' => 'sub3', 'description' => 'desc3', 'sample' => 'sample3'),
                array('placeholder' => 'sub4', 'description' => 'desc4', 'sample' => 'sample4'),
            ),
            array()
        );
        $structures = new StructurePool(array(
            'structure1' => $structure1,
            'structure2' => $structure2
        ));

        $source->fetchData(Argument::any(), Argument::any())->will(function($args) use ($structures) {
            $structure = $structures[$args[0]];
            return array_reduce(
                $structure->getChildren(),
                function ($acc, $def) { return array_merge($acc, array($def['name'] => $def['name'])); },
                $structure->getDescriptions()
            );
        });

        $this->beConstructedWith($source, $structures);
        $this->process('structure1', null)->shouldReturn(array(
            'sub1'             => 'desc1',
            'sub2'             => 'desc2',
            'pref1_sub3_suff1' => 'desc3',
            'pref1_sub4_suff1' => 'desc4',
        ));
    }
}
