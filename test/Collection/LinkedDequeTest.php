<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\LinkedDeque;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\LinkedDeque
 */
class LinkedDequeTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(LinkedDeque::of('int')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $this->assertCount(10, $deque);
    }

    public function test_that_remove_first_returns_expected_item()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $output = [];
        foreach ($items as $i) {
            $output[] = $deque->removeFirst();
        }
        $this->assertSame($items, $output);
    }

    public function test_that_remove_last_returns_expected_item()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addFirst($i);
        }
        $output = [];
        foreach ($items as $i) {
            $output[] = $deque->removeLast();
        }
        $this->assertSame($items, $output);
    }

    public function test_that_remove_first_returns_item_with_removal()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $deque->removeFirst();
        $this->assertCount(9, $deque);
    }

    public function test_that_remove_last_returns_item_with_removal()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addFirst($i);
        }
        $deque->removeLast();
        $this->assertCount(9, $deque);
    }

    public function test_that_first_returns_item_without_removal()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $deque->first();
        $this->assertCount(10, $deque);
    }

    public function test_that_last_returns_item_without_removal()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addFirst($i);
        }
        $deque->last();
        $this->assertCount(10, $deque);
    }

    public function test_that_it_is_traversable()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $output = [];
        foreach ($deque as $item) {
            $output[] = $item;
        }
        $this->assertSame($items, $output);
    }

    public function test_that_to_array_returns_expected_value()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $this->assertSame($items, $deque->toArray());
    }

    public function test_that_clone_include_nested_collection()
    {
        $deque = LinkedDeque::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $deque->addLast($i);
        }
        $copy = clone $deque;
        while (!$deque->isEmpty()) {
            $deque->removeFirst();
        }
        $this->assertSame($items, $copy->toArray());
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $output = LinkedDeque::of('string');
        $deque->each(function ($item) use ($output) {
            $output->addLast($item);
        });
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame(['foo', 'bar', 'baz'], $data);
    }

    public function test_that_map_returns_expected_deque()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $output = $deque->map(function ($item) {
            return strlen($item);
        }, 'int');
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame([3, 3, 3], $data);
    }

    public function test_that_find_returns_expected_item()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $item = $deque->find(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $this->assertSame('bar', $item);
    }

    public function test_that_find_returns_null_when_item_not_found()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $item = $deque->find(function ($item) {
            return substr($item, 0, 1) === 'c';
        });
        $this->assertNull($item);
    }

    public function test_that_filter_returns_expected_deque()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $output = $deque->filter(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame(['bar', 'baz'], $data);
    }

    public function test_that_reject_returns_expected_deque()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $output = $deque->reject(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame(['foo'], $data);
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $this->assertTrue($deque->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $this->assertFalse($deque->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $this->assertTrue($deque->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $this->assertFalse($deque->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_deques()
    {
        $deque = LinkedDeque::of('string');
        $deque->addLast('foo');
        $deque->addLast('bar');
        $deque->addLast('baz');
        $parts = $deque->partition(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $data1 = [];
        foreach ($parts[0] as $item) {
            $data1[] = $item;
        }
        $data2 = [];
        foreach ($parts[1] as $item) {
            $data2[] = $item;
        }
        $this->assertTrue($data1 === ['bar', 'baz'] && $data2 === ['foo']);
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_first_throws_exception_when_empty()
    {
        LinkedDeque::of('int')->removeFirst();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_last_throws_exception_when_empty()
    {
        LinkedDeque::of('int')->removeLast();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_first_throws_exception_when_empty()
    {
        LinkedDeque::of('int')->first();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_last_throws_exception_when_empty()
    {
        LinkedDeque::of('int')->last();
    }
}
