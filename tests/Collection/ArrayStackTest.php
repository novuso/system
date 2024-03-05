<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\ArrayStack;
use Novuso\System\Collection\Iterator\ArrayStackIterator;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ArrayStack::class)]
#[CoversClass(ArrayStackIterator::class)]
class ArrayStackTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(ArrayStack::of('int')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $stack = ArrayStack::of('int');

        foreach (range(0, 9) as $i) {
            $stack->push($i);
        }

        static::assertCount(10, $stack);
    }

    public function test_that_pop_returns_expected_item()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $output = [];

        foreach ($items as $i) {
            $output[] = $stack->pop();
        }

        static::assertSame($items, array_reverse($output));
    }

    public function test_that_pop_returns_item_with_removal()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $stack->pop();

        static::assertCount(9, $stack);
    }

    public function test_that_top_returns_item_without_removal()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $stack->top();

        static::assertCount(10, $stack);
    }

    public function test_that_mixing_add_remove_operations_affects_order()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 99);

        foreach ($items as $i) {
            $stack->push($i);
            if ($i % 2 === 0) {
                $stack->pop();
            }
        }

        $remaining = [];

        for ($i = 0; $i < 50; $i++) {
            $remaining[] = $stack->pop();
        }

        static::assertSame(range(1, 99, 2), array_reverse($remaining));
    }

    public function test_that_it_is_traversable()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $output = [];

        foreach ($stack as $item) {
            $output[] = $item;
        }

        static::assertSame(array_reverse($items), $output);
    }

    public function test_that_clone_include_nested_collection()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $copy = clone $stack;

        while (!$stack->isEmpty()) {
            $stack->pop();
        }

        static::assertSame(array_reverse($items), $copy->toArray());
    }

    public function test_that_to_array_returns_expected_output()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        static::assertSame(array_reverse($items), $stack->toArray());
    }

    public function test_iteration_beyond_items_returns_null()
    {
        $stack = ArrayStack::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $stack->push($i);
        }

        $output = [];

        $iterator = $stack->getIterator();

        foreach ($iterator as $index => $item) {
            $output[] = $item;
        }

        static::assertTrue(
            $iterator->current() === null
            && $iterator->key() === null
        );
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $output = ArrayStack::of('string');

        $stack->each(function ($item) use ($output) {
            $output->push($item);
        });

        $data = [];

        foreach ($output as $item) {
            $data[] = $item;
        }

        static::assertSame(['foo', 'bar', 'baz'], $data);
    }

    public function test_that_map_returns_expected_stack()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $output = $stack->map(function ($item) {
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
        $stack = ArrayStack::of('int');
        $stack->push(5356);
        $stack->push(7489);
        $stack->push(8936);
        $stack->push(2345);

        static::assertSame(8936, $stack->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $stack = ArrayStack::of('array');
        $stack->push(['age' => 19]);
        $stack->push(['age' => 32]);
        $stack->push(['age' => 26]);

        static::assertSame(['age' => 32], $stack->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $stack = ArrayStack::of('int');
        $stack->push(5356);
        $stack->push(7489);
        $stack->push(8936);
        $stack->push(2345);

        static::assertSame(2345, $stack->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $stack = ArrayStack::of('array');
        $stack->push(['age' => 19]);
        $stack->push(['age' => 32]);
        $stack->push(['age' => 26]);

        static::assertSame(['age' => 19], $stack->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $stack = ArrayStack::of('int');
        $stack->push(1);
        $stack->push(2);
        $stack->push(3);

        static::assertSame(6, $stack->sum());
    }

    public function test_that_sum_returns_null_with_empty_stack()
    {
        static::assertNull(ArrayStack::of('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $stack = ArrayStack::of('array');
        $stack->push(['age' => 19]);
        $stack->push(['age' => 32]);
        $stack->push(['age' => 26]);

        static::assertSame(77, $stack->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $stack = ArrayStack::of('int');
        $stack->push(1);
        $stack->push(2);
        $stack->push(3);

        static::assertEquals(2.0, $stack->average());
    }

    public function test_that_average_returns_null_with_empty_stack()
    {
        static::assertNull(ArrayStack::of('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $stack = ArrayStack::of('array');
        $stack->push(['age' => 18]);
        $stack->push(['age' => 31]);
        $stack->push(['age' => 26]);

        static::assertEquals(25.0, $stack->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_find_returns_expected_item()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $item = $stack->find(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertSame('baz', $item);
    }

    public function test_that_find_returns_null_when_item_not_found()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $item = $stack->find(function ($item) {
            return substr($item, 0, 1) === 'c';
        });

        static::assertNull($item);
    }

    public function test_that_filter_returns_expected_stack()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $output = $stack->filter(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        $data = [];

        foreach ($output as $item) {
            $data[] = $item;
        }

        static::assertSame(['baz', 'bar'], $data);
    }

    public function test_that_reject_returns_expected_stack()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $output = $stack->reject(function ($item) {
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
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertTrue($stack->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertFalse($stack->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertTrue($stack->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertFalse($stack->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_stacks()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        $parts = $stack->partition(function ($item) {
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

        static::assertTrue($data1 === ['baz', 'bar'] && $data2 === ['foo']);
    }

    public function test_that_to_json_returns_expected_value()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertSame('["baz","bar","foo"]', $stack->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertSame('["baz","bar","foo"]', json_encode($stack));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertSame('["baz","bar","foo"]', $stack->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $stack = ArrayStack::of('string');
        $stack->push('foo');
        $stack->push('bar');
        $stack->push('baz');

        static::assertSame('["baz","bar","foo"]', (string) $stack);
    }

    public function test_that_push_triggers_assert_error_for_invalid_item_type()
    {
        static::expectException(AssertionException::class);

        ArrayStack::of('int')->push('string');
    }

    public function test_that_pop_throws_exception_when_empty()
    {
        static::expectException(UnderflowException::class);

        ArrayStack::of('int')->pop();
    }

    public function test_that_top_throws_exception_when_empty()
    {
        static::expectException(UnderflowException::class);

        ArrayStack::of('int')->top();
    }
}
