<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\HashTable;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\HashTable
 * @covers \Novuso\System\Collection\Traits\KeyValueTypeMethods
 */
class HashTableTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(HashTable::of('string', 'string')->isEmpty());
    }

    public function test_that_duplicate_keys_do_not_affect_count()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');
        $hashTable->set('foo', 'bar');
        $this->assertSame(2, count($hashTable));
    }

    public function test_that_get_returns_expected_value_for_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');
        $this->assertSame('bar', $hashTable->get('foo'));
    }

    public function test_that_has_returns_true_when_key_is_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $this->assertTrue($hashTable->has('foo'));
    }

    public function test_that_has_returns_false_when_key_is_not_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $this->assertFalse($hashTable->has('baz'));
    }

    public function test_that_has_returns_false_after_key_is_removed()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->remove('foo');
        $this->assertFalse($hashTable->has('foo'));
    }

    public function test_that_offset_get_returns_expected_value_for_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertSame('bar', $hashTable['foo']);
    }

    public function test_that_offset_exists_returns_true_when_key_is_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $this->assertTrue(isset($hashTable['foo']));
    }

    public function test_that_offset_exists_returns_false_when_key_is_not_in_the_table()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $this->assertFalse(isset($hashTable['baz']));
    }

    public function test_that_offset_exists_returns_false_after_key_is_removed()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        unset($hashTable['foo']);
        $this->assertFalse(isset($hashTable['foo']));
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
        $this->assertContains('foo', $output);
    }

    public function test_that_it_is_traversable()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable->set('foo', 'bar');
        $hashTable->set('baz', 'buz');
        foreach ($hashTable as $key => $value) {
            if ($key === 'baz') {
                $this->assertSame('buz', $value);
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
        $this->assertSame($items, $output);
    }

    public function test_that_iterator_key_returns_null_when_invalid()
    {
        $hashTable = HashTable::of('string', 'string');
        $this->assertNull($hashTable->getIterator()->key());
    }

    public function test_that_iterator_current_returns_null_when_invalid()
    {
        $hashTable = HashTable::of('string', 'string');
        $this->assertNull($hashTable->getIterator()->current());
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
        $this->assertCount(2, $data);
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
        $this->assertSame(['foo' => 3, 'baz' => 3], $data);
    }

    public function test_that_find_returns_expected_key()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $key = $hashTable->find(function ($value, $key) {
            return substr($key, 0, 1) === 'f';
        });
        $this->assertSame('foo', $key);
    }

    public function test_that_find_returns_null_when_value_not_found()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $key = $hashTable->find(function ($value, $key) {
            return substr($value, 0, 1) === 'c';
        });
        $this->assertNull($key);
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
        $this->assertSame(['baz' => 'buz'], $data);
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
        $this->assertSame(['foo' => 'bar'], $data);
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertTrue($hashTable->any(function ($value, $key) {
            return $key === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertFalse($hashTable->any(function ($value, $key) {
            return $key === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertTrue($hashTable->every(function ($value, $key) {
            return strlen($value) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $hashTable = HashTable::of('string', 'string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertFalse($hashTable->every(function ($value, $key) {
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
        $this->assertTrue($data1 === ['baz' => 'buz'] && $data2 === ['foo' => 'bar']);
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_set_triggers_assert_error_for_invalid_key_type()
    {
        HashTable::of('string', 'string')->set(10, 'foo');
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_set_triggers_assert_error_for_invalid_value_type()
    {
        HashTable::of('string', 'string')->set('foo', 10);
    }

    /**
     * @expectedException \Novuso\System\Exception\KeyException
     */
    public function test_that_get_throws_exception_for_key_not_found()
    {
        HashTable::of('string', 'string')->get('foo');
    }
}
