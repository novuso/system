<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\HashTable;
use Novuso\System\Collection\Traits\KeyValueTypeMethods;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\KeyException;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(HashTable::class)]
#[CoversClass(KeyValueTypeMethods::class)]
class HashTableTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(HashTable::of('string', 'string')->isEmpty());
    }

    public function test_that_duplicate_keys_do_not_affect_count()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');
        $hashTable->set('foo', 'bar');

        static::assertSame(2, count($hashTable));
    }

    public function test_that_get_returns_expected_value_for_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');

        static::assertSame('bar', $hashTable->get('foo'));
    }

    public function test_that_has_returns_true_when_key_is_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');

        static::assertTrue($hashTable->has('foo'));
    }

    public function test_that_has_returns_false_when_key_is_not_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');

        static::assertFalse($hashTable->has('baz'));
    }

    public function test_that_has_returns_false_after_key_is_removed()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->remove('foo');

        static::assertFalse($hashTable->has('foo'));
    }

    public function test_that_offset_get_returns_expected_value_for_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        static::assertSame('bar', $hashTable['foo']);
    }

    public function test_that_offset_exists_returns_true_when_key_is_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';

        static::assertTrue(isset($hashTable['foo']));
    }

    public function test_that_offset_exists_returns_false_when_key_is_not_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';

        static::assertFalse(isset($hashTable['baz']));
    }

    public function test_that_offset_exists_returns_false_after_key_is_removed()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        unset($hashTable['foo']);

        static::assertFalse(isset($hashTable['foo']));
    }

    public function test_that_keys_returns_traversable_list_of_keys()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');
        $keys = $hashTable->keys();

        $output = [];

        foreach ($keys as $key) {
            $output[] = $key;
        }

        static::assertContains('foo', $output);
    }

    public function test_that_it_is_traversable()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');

        foreach ($hashTable as $key => $value) {
            if ($key === 'baz') {
                static::assertSame('buz', $value);
            }
        }
    }

    public function test_that_clone_include_nested_collection()
    {
        $hashTable = HashTable::of('int', 'int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $hashTable->set($i, $i);
        }

        $copy = clone $hashTable;

        foreach ($items as $i) {
            $hashTable->remove($i);
        }

        $output = [];

        foreach ($copy->keys() as $key) {
            $output[] = $key;
        }

        static::assertSame($items, $output);
    }

    public function test_that_iterator_key_returns_null_when_invalid()
    {
        $hashTable = HashTable::of('string', 'string');

        static::assertNull($hashTable->getIterator()->key());
    }

    public function test_that_iterator_current_returns_null_when_invalid()
    {
        $hashTable = HashTable::of('string', 'string');

        static::assertNull($hashTable->getIterator()->current());
    }

    public function test_that_each_calls_callback_with_each_value()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $output = HashTable::of('string', 'string');

        $hashTable->each(function ($value, $key) use ($output) {
            $output->set($key, $value);
        });

        $data = [];

        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }

        static::assertCount(2, $data);
    }

    public function test_that_map_returns_expected_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $output = $hashTable->map(function ($value, $key) {
            return strlen($value);
        }, 'int');

        $data = [];

        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }

        static::assertSame(['foo' => 3, 'baz' => 3], $data);
    }

    public function test_that_max_returns_expected_value()
    {
        $hashTable = HashTable::of('int', 'int');
        $hashTable->set(1, 5356);
        $hashTable->set(2, 7489);
        $hashTable->set(3, 8936);

        static::assertSame(3, $hashTable->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $hashTable = HashTable::of('string', 'array');
        $hashTable->set('joe', ['age' => 19]);
        $hashTable->set('bob', ['age' => 32]);
        $hashTable->set('sue', ['age' => 26]);

        static::assertSame('bob', $hashTable->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $hashTable = HashTable::of('int', 'int');
        $hashTable->set(1, 5356);
        $hashTable->set(2, 7489);
        $hashTable->set(3, 8936);

        static::assertSame(1, $hashTable->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $hashTable = HashTable::of('string', 'array');
        $hashTable->set('joe', ['age' => 19]);
        $hashTable->set('bob', ['age' => 32]);
        $hashTable->set('sue', ['age' => 26]);

        static::assertSame('joe', $hashTable->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $hashTable = HashTable::of('int', 'int');
        $hashTable->set(1, 1);
        $hashTable->set(2, 2);
        $hashTable->set(3, 3);

        static::assertSame(6, $hashTable->sum());
    }

    public function test_that_sum_returns_null_with_empty_set()
    {
        static::assertNull(HashTable::of('int', 'int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $hashTable = HashTable::of('string', 'array');
        $hashTable->set('joe', ['age' => 19]);
        $hashTable->set('bob', ['age' => 32]);
        $hashTable->set('sue', ['age' => 26]);

        static::assertSame(77, $hashTable->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $hashTable = HashTable::of('int', 'int');
        $hashTable->set(1, 1);
        $hashTable->set(2, 2);
        $hashTable->set(3, 3);

        static::assertEquals(2.0, $hashTable->average());
    }

    public function test_that_average_returns_null_with_empty_set()
    {
        static::assertNull(HashTable::of('int', 'int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $hashTable = HashTable::of('string', 'array');
        $hashTable->set('joe', ['age' => 18]);
        $hashTable->set('bob', ['age' => 31]);
        $hashTable->set('sue', ['age' => 26]);

        static::assertEquals(25.0, $hashTable->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_find_returns_expected_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $key = $hashTable->find(function ($value, $key) {
            return substr($key, 0, 1) === 'f';
        });

        static::assertSame('foo', $key);
    }

    public function test_that_find_returns_null_when_value_not_found()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $key = $hashTable->find(function ($value, $key) {
            return substr($value, 0, 1) === 'c';
        });

        static::assertNull($key);
    }

    public function test_that_filter_returns_expected_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $output = $hashTable->filter(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        });

        $data = [];

        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }

        static::assertSame(['baz' => 'buz'], $data);
    }

    public function test_that_reject_returns_expected_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $output = $hashTable->reject(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        });

        $data = [];

        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }

        static::assertSame(['foo' => 'bar'], $data);
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        static::assertTrue($hashTable->any(function ($value, $key) {
            return $key === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        static::assertFalse($hashTable->any(function ($value, $key) {
            return $key === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        static::assertTrue($hashTable->every(function ($value, $key) {
            return strlen($value) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        static::assertFalse($hashTable->every(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_tables()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';

        $parts = $hashTable->partition(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        });

        $data1 = [];

        foreach ($parts[0] as $key => $value) {
            $data1[$key] = $value;
        }

        $data2 = [];

        foreach ($parts[1] as $key => $value) {
            $data2[$key] = $value;
        }

        static::assertTrue($data1 === ['baz' => 'buz'] && $data2 === ['foo' => 'bar']);
    }

    public function test_that_set_triggers_assert_error_for_invalid_key_type()
    {
        static::expectException(AssertionException::class);

        HashTable::of('string', 'string')->set(10, 'foo');
    }

    public function test_that_set_triggers_assert_error_for_invalid_value_type()
    {
        static::expectException(AssertionException::class);

        HashTable::of('string', 'string')->set('foo', 10);
    }

    public function test_that_get_throws_exception_for_key_not_found()
    {
        static::expectException(KeyException::class);

        HashTable::of('string', 'string')->get('foo');
    }
}
