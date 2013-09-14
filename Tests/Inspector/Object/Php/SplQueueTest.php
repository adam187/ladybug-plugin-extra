<?php

namespace Ladybug\Tests\Plugin\Extra\Inspector\Object\Php;

use Ladybug\Inspector;
use Ladybug\Type;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Plugin\Extra\Inspector\Object\Php\SplQueue;
use \Mockery as m;

class SplQueueTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplQueue */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $extendedTypeFactoryMock = m::mock('Ladybug\Type\Extended\ExtendedTypeFactory');
        $extendedTypeFactoryMock->shouldReceive('factory')->with('collection', m::any())->andReturn(new Type\Extended\CollectionType());

        $this->inspector = new SplQueue($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = new \SplQueue();
        $var->push(1);
        $var->push(2);
        $var->push(3);

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_CLASS);

        $result = $this->inspector->getData($data);

        $this->assertInstanceOf('Ladybug\Type\Extended\CollectionType', $result);
        $this->assertCount(3, $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_CLASS);

        $this->inspector->getData($data);
    }

}
