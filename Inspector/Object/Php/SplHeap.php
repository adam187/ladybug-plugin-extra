<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/SplHeap dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Plugin\Extra\Inspector\Object\Php;

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Type;

abstract class SplHeap extends AbstractInspector
{

    public function getData(InspectorDataWrapper $data)
    {
        if (!$this->accept($data)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var $var \SplHeap */

        $arrayData = iterator_to_array($data->getData());

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);

        $collection->setTitle('Heap');

        foreach ($arrayData as $item) {
            $collection->add($this->typeFactory->factory($item, $this->level + 1));
        }

        return $collection;
    }

}
