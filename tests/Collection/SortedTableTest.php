<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\SortedTable;
use Novuso\System\Exception\KeyException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\SortedTable
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
        $this->assertTrue(SortedTable::comparable(TestWeekDay::class, 'string')->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertCount(7, $table);
    }

    public function test_that_duplicate_keys_are_overridden()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        $table->set(TestWeekDay::TUESDAY(), 'Tacos');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertEquals('Tuesday', $table->get(TestWeekDay::TUESDAY()));
    }

    public function test_that_has_returns_true_for_valid_key()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue($table->has(TestWeekDay::SATURDAY()));
    }

    public function test_that_remove_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
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
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table[$key] = $value;
        }
        $this->assertSame('Monday', $table[TestWeekDay::MONDAY()]);
    }

    public function test_that_offset_exists_returns_true_for_valid_key()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table[$key] = $value;
        }
        $this->assertTrue(isset($table[TestWeekDay::SATURDAY()]));
    }

    public function test_that_offset_unset_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
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
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        $keys = $table->keys();
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(0, $count);
    }

    public function test_that_keys_returns_traversable_keys_in_order()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
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
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $keys = $table->rangeKeys(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_includes_key_arguments_when_present()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = $table->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_key_arguments_when_missing()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(TestWeekDay::THURSDAY());
        $count = $table->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $this->assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $count = $table->rangeCount(TestWeekDay::THURSDAY(), TestWeekDay::TUESDAY());
        $this->assertSame(0, $count);
    }

    public function test_that_remove_min_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $table->removeMin();
        }
        $this->assertSame('Saturday', $table->get(TestWeekDay::SATURDAY()));
    }

    public function test_that_remove_min_correctly_finds_and_removes_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 19]);
        $table->set('bob', ['age' => 32]);
        $table->set('sue', ['age' => 26]);
        $table->removeMin(function (array $data) {
            return $data['age'];
        });
        $this->assertFalse($table->has('joe'));
    }

    public function test_that_remove_max_correctly_finds_and_removes()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $table->removeMax();
        }
        $this->assertSame('Sunday', $table->get(TestWeekDay::SUNDAY()));
    }

    public function test_that_remove_max_correctly_finds_and_removes_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 19]);
        $table->set('bob', ['age' => 32]);
        $table->set('sue', ['age' => 26]);
        $table->removeMax(function (array $data) {
            return $data['age'];
        });
        $this->assertFalse($table->has('bob'));
    }

    public function test_that_floor_returns_equal_key_when_present()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::FRIDAY()->equals($table->floor(TestWeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_key_equal_or_less_than_arg()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(TestWeekDay::THURSDAY());
        $this->assertTrue(TestWeekDay::WEDNESDAY()->equals($table->floor(TestWeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_key_not_found()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(TestWeekDay::SUNDAY());
        $this->assertNull($table->floor(TestWeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_key_when_present()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::MONDAY()->equals($table->ceiling(TestWeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_key_equal_or_greater_than_arg()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(TestWeekDay::TUESDAY());
        $this->assertTrue(TestWeekDay::WEDNESDAY()->equals($table->ceiling(TestWeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_key_not_found()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $table->remove(TestWeekDay::SATURDAY());
        $this->assertNull($table->ceiling(TestWeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_key()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertSame(4, $table->rank(TestWeekDay::THURSDAY()));
    }

    public function test_that_select_returns_key_assoc_with_rank()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::THURSDAY()->equals($table->select(4)));
    }

    public function test_that_it_is_traversable()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
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
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
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
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $iterator = $table->getIterator();
        $count = 0;
        foreach ($iterator as $key => $value) {
            $count++;
        }
        $this->assertNull($iterator->key());
    }

    public function test_that_iterator_returns_null_for_invalid_value()
    {
        $table = SortedTable::comparable(TestWeekDay::class, 'string');
        foreach ($this->getWeekDays() as $value => $key) {
            $table->set($key, $value);
        }
        $iterator = $table->getIterator();
        $count = 0;
        foreach ($iterator as $key => $value) {
            $count++;
        }
        $this->assertNull($iterator->current());
    }

    public function test_that_each_calls_callback_with_each_value()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $output = SortedTable::string('string');
        $table->each(function ($value, $key) use ($output) {
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
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $output = $table->map(function ($value, $key) {
            return strlen($value);
        }, 'int');
        $data = [];
        foreach ($output as $key => $value) {
            $data[$key] = $value;
        }
        $this->assertSame(['baz' => 3, 'foo' => 3], $data);
    }

    public function test_that_max_returns_expected_value()
    {
        $table = SortedTable::integer('int');
        $table->set(1, 5356);
        $table->set(2, 7489);
        $table->set(3, 8936);
        $this->assertSame(3, $table->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 19]);
        $table->set('bob', ['age' => 32]);
        $table->set('sue', ['age' => 26]);
        $this->assertSame('bob', $table->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $table = SortedTable::integer('int');
        $table->set(1, 5356);
        $table->set(2, 7489);
        $table->set(3, 8936);
        $this->assertSame(1, $table->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 19]);
        $table->set('bob', ['age' => 32]);
        $table->set('sue', ['age' => 26]);
        $this->assertSame('joe', $table->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $table = SortedTable::integer('int');
        $table->set(1, 1);
        $table->set(2, 2);
        $table->set(3, 3);
        $this->assertSame(6, $table->sum());
    }

    public function test_that_sum_returns_null_with_empty_set()
    {
        $this->assertNull(SortedTable::integer('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 19]);
        $table->set('bob', ['age' => 32]);
        $table->set('sue', ['age' => 26]);
        $this->assertSame(77, $table->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $table = SortedTable::callback(function (int $item1, int $item2) {
            return $item1 <=> $item2;
        }, 'int', 'int');
        $table->set(1, 1);
        $table->set(2, 2);
        $table->set(3, 3);
        $this->assertEquals(2.0, $table->average());
    }

    public function test_that_average_returns_null_with_empty_set()
    {
        $this->assertNull(SortedTable::integer('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $table = SortedTable::string('array');
        $table->set('joe', ['age' => 18]);
        $table->set('bob', ['age' => 31]);
        $table->set('sue', ['age' => 26]);
        $this->assertEquals(25.0, $table->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_find_returns_expected_key()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $key = $table->find(function ($value, $key) {
            return substr($value, 0, 1) === 'b';
        });
        $this->assertSame('baz', $key);
    }

    public function test_that_find_returns_null_when_value_not_found()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $key = $table->find(function ($value, $key) {
            return substr($value, 0, 1) === 'c';
        });
        $this->assertNull($key);
    }

    public function test_that_filter_returns_expected_table()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $output = $table->filter(function ($value, $key) {
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
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $output = $table->reject(function ($value, $key) {
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
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $this->assertTrue($table->any(function ($value, $key) {
            return $key === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $this->assertFalse($table->any(function ($value, $key) {
            return $key === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $this->assertTrue($table->every(function ($value, $key) {
            return strlen($value) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $this->assertFalse($table->every(function ($value, $key) {
            return substr($key, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_tables()
    {
        $table = SortedTable::string('string');
        $table['foo'] = 'bar';
        $table['baz'] = 'buz';
        $parts = $table->partition(function ($value, $key) {
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

    public function test_that_get_throws_exception_for_undefined_key()
    {
        $this->expectException(KeyException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->get(TestWeekDay::SUNDAY());
    }

    public function test_that_min_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->min();
    }

    public function test_that_max_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->max();
    }

    public function test_that_remove_min_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->removeMin();
    }

    public function test_that_remove_max_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->removeMax();
    }

    public function test_that_floor_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->floor(TestWeekDay::WEDNESDAY());
    }

    public function test_that_ceiling_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->ceiling(TestWeekDay::WEDNESDAY());
    }

    public function test_that_select_throws_exception_when_rank_out_of_bounds()
    {
        $this->expectException(LookupException::class);
        SortedTable::comparable(TestWeekDay::class, 'string')->select(10);
    }

    protected function getWeekDays()
    {
        return [
            'Monday'    => TestWeekDay::MONDAY(),
            'Wednesday' => TestWeekDay::WEDNESDAY(),
            'Friday'    => TestWeekDay::FRIDAY(),
            'Tuesday'   => TestWeekDay::TUESDAY(),
            'Thursday'  => TestWeekDay::THURSDAY(),
            'Saturday'  => TestWeekDay::SATURDAY(),
            'Sunday'    => TestWeekDay::SUNDAY()
        ];
    }
}
