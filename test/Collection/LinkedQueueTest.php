<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\LinkedQueue;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\LinkedQueue
 */
class LinkedQueueTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(LinkedQueue::of('int')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $this->assertCount(10, $queue);
    }

    public function test_that_dequeue_returns_expected_item()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $output = [];
        foreach ($items as $i) {
            $output[] = $queue->dequeue();
        }
        $this->assertSame($items, $output);
    }

    public function test_that_dequeue_returns_item_with_removal()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $queue->dequeue();
        $this->assertCount(9, $queue);
    }

    public function test_that_front_returns_item_without_removal()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $queue->front();
        $this->assertCount(10, $queue);
    }

    public function test_that_mixing_add_remove_operations_keeps_order()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 99);
        foreach ($items as $i) {
            $queue->enqueue($i);
            if ($i % 2 === 0) {
                $queue->dequeue();
            }
        }
        $remaining = [];
        for ($i = 0; $i < 50; $i++) {
            $remaining[] = $queue->dequeue();
        }
        $this->assertSame(range(50, 99), $remaining);
    }

    public function test_that_it_is_traversable()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $output = [];
        foreach ($queue as $item) {
            $output[] = $item;
        }
        $this->assertSame($items, $output);
    }

    public function test_that_to_array_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $this->assertSame($items, $queue->toArray());
    }

    public function test_that_clone_include_nested_collection()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);
        foreach ($items as $i) {
            $queue->enqueue($i);
        }
        $copy = clone $queue;
        while (!$queue->isEmpty()) {
            $queue->dequeue();
        }
        $this->assertSame($items, $copy->toArray());
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $output = LinkedQueue::of('string');
        $queue->each(function ($item) use ($output) {
            $output->enqueue($item);
        });
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame(['foo', 'bar', 'baz'], $data);
    }

    public function test_that_map_returns_expected_queue()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $output = $queue->map(function ($item) {
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
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $item = $queue->find(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $this->assertSame('bar', $item);
    }

    public function test_that_find_returns_null_when_item_not_found()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $item = $queue->find(function ($item) {
            return substr($item, 0, 1) === 'c';
        });
        $this->assertNull($item);
    }

    public function test_that_filter_returns_expected_queue()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $output = $queue->filter(function ($item) {
            return substr($item, 0, 1) === 'b';
        });
        $data = [];
        foreach ($output as $item) {
            $data[] = $item;
        }
        $this->assertSame(['bar', 'baz'], $data);
    }

    public function test_that_reject_returns_expected_queue()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $output = $queue->reject(function ($item) {
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
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $this->assertTrue($queue->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $this->assertFalse($queue->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $this->assertTrue($queue->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $this->assertFalse($queue->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_queues()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');
        $parts = $queue->partition(function ($item) {
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
     * @expectedException \AssertionError
     */
    public function test_that_enqueue_triggers_assert_error_for_invalid_item_type()
    {
        LinkedQueue::of('int')->enqueue('string');
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_dequeue_throws_exception_when_empty()
    {
        LinkedQueue::of('int')->dequeue();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_front_throws_exception_when_empty()
    {
        LinkedQueue::of('int')->front();
    }
}
