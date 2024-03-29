<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\LinkedQueue;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LinkedQueue::class)]
class LinkedQueueTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(LinkedQueue::of('int')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $queue->enqueue($i);
        }

        static::assertCount(10, $queue);
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

        static::assertSame($items, $output);
    }

    public function test_that_dequeue_returns_item_with_removal()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $queue->enqueue($i);
        }

        $queue->dequeue();

        static::assertCount(9, $queue);
    }

    public function test_that_front_returns_item_without_removal()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $queue->enqueue($i);
        }

        $queue->front();

        static::assertCount(10, $queue);
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

        static::assertSame(range(50, 99), $remaining);
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

        static::assertSame($items, $output);
    }

    public function test_that_to_array_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $queue->enqueue($i);
        }

        static::assertSame($items, $queue->toArray());
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

        static::assertSame($items, $copy->toArray());
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

        static::assertSame(['foo', 'bar', 'baz'], $data);
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

        static::assertSame([3, 3, 3], $data);
    }

    public function test_that_max_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $queue->enqueue(5356);
        $queue->enqueue(7489);
        $queue->enqueue(8936);
        $queue->enqueue(2345);

        static::assertSame(8936, $queue->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $queue = LinkedQueue::of('array');
        $queue->enqueue(['age' => 19]);
        $queue->enqueue(['age' => 32]);
        $queue->enqueue(['age' => 26]);

        static::assertSame(['age' => 32], $queue->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $queue->enqueue(5356);
        $queue->enqueue(7489);
        $queue->enqueue(8936);
        $queue->enqueue(2345);

        static::assertSame(2345, $queue->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $queue = LinkedQueue::of('array');
        $queue->enqueue(['age' => 19]);
        $queue->enqueue(['age' => 32]);
        $queue->enqueue(['age' => 26]);

        static::assertSame(['age' => 19], $queue->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->enqueue(3);

        static::assertSame(6, $queue->sum());
    }

    public function test_that_sum_returns_null_with_empty_queue()
    {
        static::assertNull(LinkedQueue::of('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $queue = LinkedQueue::of('array');
        $queue->enqueue(['age' => 19]);
        $queue->enqueue(['age' => 32]);
        $queue->enqueue(['age' => 26]);

        static::assertSame(77, $queue->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $queue = LinkedQueue::of('int');
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->enqueue(3);

        static::assertEquals(2.0, $queue->average());
    }

    public function test_that_average_returns_null_with_empty_queue()
    {
        static::assertNull(LinkedQueue::of('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $queue = LinkedQueue::of('array');
        $queue->enqueue(['age' => 18]);
        $queue->enqueue(['age' => 31]);
        $queue->enqueue(['age' => 26]);

        static::assertEquals(25.0, $queue->average(function (array $data) {
            return $data['age'];
        }));
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

        static::assertSame('bar', $item);
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

        static::assertNull($item);
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

        static::assertSame(['bar', 'baz'], $data);
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

        static::assertSame(['foo'], $data);
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertTrue($queue->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertFalse($queue->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertTrue($queue->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertFalse($queue->every(function ($item) {
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

        static::assertTrue($data1 === ['bar', 'baz'] && $data2 === ['foo']);
    }

    public function test_that_to_json_returns_expected_value()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertSame('["foo","bar","baz"]', $queue->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertSame('["foo","bar","baz"]', json_encode($queue));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertSame('["foo","bar","baz"]', $queue->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $queue = LinkedQueue::of('string');
        $queue->enqueue('foo');
        $queue->enqueue('bar');
        $queue->enqueue('baz');

        static::assertSame('["foo","bar","baz"]', (string) $queue);
    }

    public function test_that_enqueue_triggers_assert_error_for_invalid_item_type()
    {
        static::expectException(AssertionException::class);

        LinkedQueue::of('int')->enqueue('string');
    }

    public function test_that_dequeue_throws_exception_when_empty()
    {
        static::expectException(UnderflowException::class);

        LinkedQueue::of('int')->dequeue();
    }

    public function test_that_front_throws_exception_when_empty()
    {
        static::expectException(UnderflowException::class);

        LinkedQueue::of('int')->front();
    }
}
