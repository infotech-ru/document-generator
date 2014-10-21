<?php

namespace spec\Infotech\DocumentGenerator\DataStructure\MetadataSource;

use Infotech\DocumentGenerator\DataStructure\Definition\StructureDefinitionInterface;
use PhpSpec\ObjectBehavior;

class DescriptionsFetcherSpec extends ObjectBehavior
{
    function it_is_initializable(StructureDefinitionInterface $structure)
    {
        $this->beConstructedWith($structure);
        $this->shouldHaveType('Infotech\DocumentGenerator\DataStructure\MetadataSource\DescriptionsFetcher');
    }

    function it_should_fetch_descriptions(StructureDefinitionInterface $structure)
    {
        $structure->getDescriptions()->willReturn(array(
            'placeholder1' => 'desc1',
            'placeholder2' => 'desc2',
            'placeholder3' => 'desc3',
        ));
        $structure->getChildren()->willReturn(array(
            array('name' => 'child1', 'prefix' => '', 'suffix' => '')
        ));

        $this->beConstructedWith($structure);
        $this->getData(null)->shouldReturn(array(
            'placeholder1' => 'desc1',
            'placeholder2' => 'desc2',
            'placeholder3' => 'desc3',
            'child1' => 'child1'
        ));
    }
}
