<?php

namespace spec\Infotech\DocumentGenerator\Util;

use PhpSpec\ObjectBehavior;

class PropertyAccessSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Infotech\DocumentGenerator\Util\PropertyAccess');
    }

    function it_should_access_array_item()
    {
        $array = array('item' => 'value');
        $this->get($array, 'item')->shouldReturn('value');
    }

    function it_should_access_object_public_property()
    {
        $object = (object)array('item' => 'value');
        $this->get($object, 'item')->shouldReturn('value');
    }

    function it_should_access_object_getter(ObjectStubInterface $object)
    {
        $object->getItem()->willReturn('value');
        $this->get($object, 'item')->shouldReturn('value');
    }
}

interface ObjectStubInterface
{
    public function getItem();
}
