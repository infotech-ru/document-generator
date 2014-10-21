<?php

namespace spec\Infotech\DocumentGenerator\DataStructure\Definition;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommonStructureDefinitionSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->beConstructedWith(array(), array());
        $this->shouldHaveType('Infotech\DocumentGenerator\DataStructure\Definition\CommonStructureDefinition');
    }

    function it_is_initializable_with_placeholders_enumerated()
    {
        $placeholders = array(
            array('placeholder' => 'SUBST1', 'description' => 'desc1'),
            array('placeholder' => 'SUBST2', 'description' => 'desc2'),
        );
        $this->beConstructedWith($placeholders, array());
        $this->shouldHaveType('Infotech\DocumentGenerator\DataStructure\Definition\CommonStructureDefinition');
    }

    function it_cant_be_initialized_with_non_unique_placeholders()
    {
        $placeholders = array(
            array('placeholder' => 'SUBST', 'description' => 'desc1', 'sample' => 'sample1'),
            array('placeholder' => 'SUBST', 'description' => 'desc2', 'sample' => 'sample2'),
        );
        $this->shouldThrow('Infotech\DocumentGenerator\DataStructure\Definition\Exception\DefinitionDuplicateException')
            ->during('__construct', array($placeholders, array()));
    }

    function it_cant_be_initialized_with_invalid_placeholders_definition_array()
    {
        $placeholders = array(array('placeholder' => array()));
        $this->shouldThrow('Infotech\DocumentGenerator\DataStructure\Definition\Exception\InvalidDefinitionException')
            ->during('__construct', array($placeholders, array()));
    }

    function it_cant_be_initialized_with_string_placeholder_definition()
    {
        $placeholders = array(array('placeholder' => 'definition'));
        $this->shouldThrow('Infotech\DocumentGenerator\DataStructure\Definition\Exception\InvalidDefinitionException')
            ->during('__construct', array($placeholders, array()));
    }

    function it_should_not_say_has_placeholders_when_it_has_not()
    {
        $this->beConstructedWith(array(), array());
        $this->shouldNotHavePlaceholders();
    }

    function it_should_say_has_placeholders_when_it_has()
    {
        $placeholders = array(array('placeholder' => 'SUBST', 'description' => 'desc1', 'sample' => 'sample1'));
        $this->beConstructedWith($placeholders, array());
        $this->shouldHavePlaceholders();
    }

    function it_should_return_placeholders()
    {
        $placeholders = array(
            array('placeholder' => 'SUBST1', 'description' => 'desc1', 'sample' => 'sample1'),
            array('placeholder' => 'SUBST2', 'description' => 'desc2', 'sample' => 'sample2'),
        );
        $this->beConstructedWith($placeholders, array());
        $this->getPlaceholders()->shouldHaveCount(2);
    }

    function it_is_initializable_with_children_enumerated()
    {
        $structures = array(
            array('structure' => 'struct'),
        );
        $this->beConstructedWith(array(), $structures);
        $this->shouldHaveType('Infotech\DocumentGenerator\DataStructure\Definition\CommonStructureDefinition');
    }

    function it_cant_be_initialized_with_non_unique_children()
    {
        $children = array(
            array('name' => 'struct'),
            'struct',
        );
        $this->shouldThrow('Infotech\DocumentGenerator\DataStructure\Definition\Exception\DefinitionDuplicateException')
            ->during('__construct', array(array(), $children));
    }

    function it_cant_be_initialized_with_invalid_children_definition_array()
    {
        $children = array(array('prefix' => 'SOME_'));
        $this->shouldThrow('Infotech\DocumentGenerator\DataStructure\Definition\Exception\InvalidDefinitionException')
            ->during('__construct', array(array(), $children));
    }

    function it_should_not_say_has_children_when_it_has_not()
    {
        $this->beConstructedWith(array(), array());
        $this->shouldNotHaveChildren();
    }

    function it_should_say_has_children_when_it_has()
    {
        $children = array('struct');
        $this->beConstructedWith(array(), $children);
        $this->shouldHaveChildren();
    }

    function it_should_return_children()
    {
        $children = array(
            array('name' => 'struct1'),
            'struct2',
        );
        $this->beConstructedWith(array(), $children);
        $this->getChildren()->shouldHaveCount(2);
    }

    function it_should_return_samples()
    {
        $placeholders = array(
            array('placeholder' => 'SUBST1', 'description' => 'desc1', 'sample' => 'sample1'),
            array('placeholder' => 'SUBST2', 'description' => 'desc2', 'sample' => 'sample2'),
        );
        $this->beConstructedWith($placeholders, array());
        $this->getSamples()->shouldReturn(array('SUBST1' => 'sample1', 'SUBST2' => 'sample2'));
    }

    function it_should_return_descriptions()
    {
        $placeholders = array(
            array('placeholder' => 'SUBST1', 'description' => 'desc1', 'sample' => 'sample1'),
            array('placeholder' => 'SUBST2', 'description' => 'desc2', 'sample' => 'sample2'),
        );
        $this->beConstructedWith($placeholders, array());
        $this->getDescriptions()->shouldReturn(array('SUBST1' => 'desc1', 'SUBST2' => 'desc2'));
    }

    function it_should_add_bunch_of_placeholders()
    {
        $this->beConstructedWith(
            array(
                array('placeholder' => 'SUBST0', 'description' => 'desc0', 'sample' => 'sample0')
            ),
            array()
        );
        $this->addPlaceholders(array(
            array('placeholder' => 'SUBST1', 'description' => 'desc1', 'sample' => 'sample1'),
            array('placeholder' => 'SUBST2', 'description' => 'desc2', 'sample' => 'sample2'),
        ));
        $this->getPlaceholders()->shouldHaveCount(3);
    }

    function it_should_add_bunch_of_children()
    {
        $this->beConstructedWith(
            array(),
            array('struct0', 'struct1')
        );
        $this->addChildren(array('struct2', 'struct3'));
        $this->getChildren()->shouldHaveCount(4);
    }

    function if_should_return_empty_values()
    {
        $this->beConstructedWith(
            array(
                array('placeholder' => 'SUBST0', 'description' => 'desc0', 'sample' => 'sample0', 'empty' => 'empty0'),
                array('placeholder' => 'SUBST1', 'description' => 'desc1', 'sample' => 'sample1', 'empty' => 'empty1'),
                array('placeholder' => 'SUBST2', 'description' => 'desc2', 'sample' => 'sample2', 'empty' => 'empty2'),
            ),
            array()
        );
        $this->getEmptyValues()->shouldReturn(array('SUBST0' => 'empty0', 'SUBST1' => 'empty1', 'SUBST2' => 'empty2'));
    }
}
