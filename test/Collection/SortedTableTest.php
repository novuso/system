<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\SortedTable;
use Novuso\Test\System\Resources\WeekDay;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Collection\SortedTable
 */
class SortedTableTest extends UnitTestCase
{
    public function test_that_float_returns_instance_with_float_key_type()
    {
        $table = SortedTable::float();
        $this->assertSame('float', $table->keyType());
    }

    public function test_that_integer_returns_instance_with_int_key_type()
    {
        $table = SortedTable::integer();
        $this->assertSame('int', $table->keyType());
    }

    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(SortedTable::comparable(WeekDay::class, 'string')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertCount(7, $table);
    }

    public function test_that_duplicate_keys_are_overridden()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        $table->set(WeekDay::TUESDAY(), 'Tacos');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertEquals('Tuesday', $table->get(WeekDay::TUESDAY()));
    }

    public function test_that_has_returns_true_for_valid_key()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue($table->has(WeekDay::SATURDAY()));
    }

    public function test_that_remove_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        foreach ($this->getWeekDays() as $value => $key) {
            $table->remove($key);
        }
        $this->assertTrue($table->isEmpty());
    }

    public function test_that_offset_set_accepts_comparable_keys()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table[$key] = $value;
        }
        $this->assertSame('Monday', $table[WeekDay::MONDAY()]);
    }

    public function test_that_offset_exists_returns_true_for_valid_key()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table[$key] = $value;
        }
        $this->assertTrue(isset($table[WeekDay::SATURDAY()]));
    }

    public function test_that_offset_unset_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table[$key] = $value;
        }
        foreach ($this->getWeekDays() as $value => $key) {
            unset($table[$key]);
        }
        $this->assertTrue($table->isEmpty());
    }

    public function test_that_keys_returns_empty_traversable_when_empty()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        $keys = $table->keys();
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(0, $count);
    }

    public function test_that_keys_returns_traversable_keys_in_order()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = 0;
        foreach ($table->keys() as $key) {
            if ($key->value() !== $count) {
                throw new \Exception('Keys out of order');
            }
            $count++;
        }
        $this->assertSame(7, $count);
    }

    public function test_that_range_keys_returns_inclusive_set()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $keys = $table->rangeKeys(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_includes_key_arguments_when_present()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = $table->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_key_arguments_when_missing()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(WeekDay::THURSDAY());
        $count = $table->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = $table->rangeCount(WeekDay::THURSDAY(), WeekDay::TUESDAY());
        $this->assertSame(0, $count);
    }

    public function test_that_remove_min_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $table->removeMin();
        }
        $this->assertSame('Saturday', $table->get(WeekDay::SATURDAY()));
    }

    public function test_that_remove_max_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $table->removeMax();
        }
        $this->assertSame('Sunday', $table->get(WeekDay::SUNDAY()));
    }

    public function test_that_floor_returns_equal_key_when_present()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(WeekDay::FRIDAY()->equals($table->floor(WeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_key_equal_or_less_than_arg()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(WeekDay::THURSDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($table->floor(WeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_key_not_found()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(WeekDay::SUNDAY());
        $this->assertNull($table->floor(WeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_key_when_present()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(WeekDay::MONDAY()->equals($table->ceiling(WeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_key_equal_or_greater_than_arg()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(WeekDay::TUESDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($table->ceiling(WeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_key_not_found()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(WeekDay::SATURDAY());
        $this->assertNull($table->ceiling(WeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_key()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertSame(4, $table->rank(WeekDay::THURSDAY()));
    }

    public function test_that_select_returns_key_assoc_with_rank()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(WeekDay::THURSDAY()->equals($table->select(4)));
    }

    public function test_that_it_is_traversable()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = 0;
        foreach ($table as $key => $value) {
            if ($key->value() !== $count) {
                throw new \Exception('Keys out of order');
            }
            $count++;
        }
        $this->assertSame(7, $count);
    }

    public function test_that_clone_include_nested_collection()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $copy = clone $table;
        while (!$table->isEmpty()) {
            $table->removeMin();
        }
        $this->assertCount(7, $copy);
    }

    public function test_that_iterator_returns_null_for_invalid_key()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $iterator = $table->getIterator();
        foreach ($iterator as $key => $value) {
            //
        }
        $this->assertNull($iterator->key());
    }

    public function test_that_iterator_returns_null_for_invalid_value()
    {
        $table = SortedTable::comparable(WeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $iterator = $table->getIterator();
        foreach ($iterator as $key => $value) {
            //
        }
        $this->assertNull($iterator->current());
    }

    public function test_that_each_calls_callback_with_each_value()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $output = SortedTable::string('string');
        $hashTable->each(function ($value, $key) use ($output) {
            $output->set($key, $value);
        });
        $data = [];
        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }
        $this->assertSame(['baz' => 'buz', 'foo' => 'bar'], $data);
    }

    public function test_that_map_returns_expected_table()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $output = $hashTable->map(function ($value, $key) {
            return strlen($value);
        }, 'int');
        $data = [];
        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }
        $this->assertSame(['baz' => 3, 'foo' => 3], $data);
    }

    public function test_that_find_returns_expected_key()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $key = $hashTable->find(function ($value, $key) {
            return substr($value, 0, 1) === 'b';
        });
        $this->assertSame('baz', $key);
    }

    public function test_that_find_returns_null_when_value_not_found()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $key = $hashTable->find(function ($value, $key) {
            return substr($value, 0, 1) === 'c';
        });
        $this->assertNull($key);
    }

    public function test_that_filter_returns_expected_table()
    {
        $hashTable = SortedTable::string('string');
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
        $hashTable = SortedTable::string('string');
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
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertTrue($hashTable->any(function ($value, $key) {
            return $key === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertFalse($hashTable->any(function ($value, $key) {
            return $key === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertTrue($hashTable->every(function ($value, $key) {
            return strlen($value) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $hashTable = SortedTable::string('string');
        $hashTable['foo'] = 'bar';
        $hashTable['baz'] = 'buz';
        $this->assertFalse($hashTable->every(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_tables()
    {
        $hashTable = SortedTable::string('string');
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
     * @expectedException \Novuso\System\Exception\KeyException
     */
    public function test_that_get_throws_exception_for_undefined_key()
    {
        SortedTable::comparable(WeekDay::class, 'string')->get(WeekDay::SUNDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_min_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->min();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_max_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->max();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_min_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->removeMin();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_max_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->removeMax();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_floor_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->floor(WeekDay::WEDNESDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_ceiling_throws_exception_when_empty()
    {
        SortedTable::comparable(WeekDay::class, 'string')->ceiling(WeekDay::WEDNESDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\LookupException
     */
    public function test_that_select_throws_exception_when_rank_out_of_bounds()
    {
        SortedTable::comparable(WeekDay::class, 'string')->select(10);
    }

    protected function getWeekDays()
    {
        return [
            'Monday'    => WeekDay::MONDAY(),
            'Wednesday' => WeekDay::WEDNESDAY(),
            'Friday'    => WeekDay::FRIDAY(),
            'Tuesday'   => WeekDay::TUESDAY(),
            'Thursday'  => WeekDay::THURSDAY(),
            'Saturday'  => WeekDay::SATURDAY(),
            'Sunday'    => WeekDay::SUNDAY()
        ];
    }
}
