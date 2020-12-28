<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\SortedSet;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Test\Resources\TestIntegerObject;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\SortedSet
 */
class SortedSetTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(SortedSet::comparable(TestWeekDay::class)->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertCount(7, $set);
    }

    public function test_that_duplicate_items_are_overridden()
    {
        $set = SortedSet::comparable(TestWeekDay::class);
        $set->add(TestWeekDay::TUESDAY());

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertCount(7, $set);
    }

    public function test_that_contains_returns_true_for_valid_item()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertTrue($set->contains(TestWeekDay::SATURDAY()));
    }

    public function test_that_remove_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        foreach ($this->getWeekDays() as $weekDay) {
            $set->remove($weekDay);
        }

        static::assertTrue($set->isEmpty());
    }

    public function test_that_difference_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $set->add(new TestIntegerObject($val));
        }

        $difference = $set->difference($set);

        static::assertTrue($difference->isEmpty());
    }

    public function test_that_difference_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(TestIntegerObject::class);
        $setOfThrees = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $setOfTwos->add(new TestIntegerObject($val));
        }

        foreach ($threes as $val) {
            $setOfThrees->add(new TestIntegerObject($val));
        }

        $validSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $invalidSet = [6, 12, 18, 24, 30];
        $difference = $setOfTwos->difference($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$difference->contains(new TestIntegerObject($val))) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($difference->contains(new TestIntegerObject($val))) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_intersection_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(TestIntegerObject::class);
        $setOfThrees = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $setOfTwos->add(new TestIntegerObject($val));
        }

        foreach ($threes as $val) {
            $setOfThrees->add(new TestIntegerObject($val));
        }

        $validSet = [6, 12, 18, 24, 30];
        $invalidSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $intersection = $setOfTwos->intersection($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$intersection->contains(new TestIntegerObject($val))) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($intersection->contains(new TestIntegerObject($val))) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_complement_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $set->add(new TestIntegerObject($val));
        }

        $complement = $set->complement($set);

        static::assertTrue($complement->isEmpty());
    }

    public function test_that_complement_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(TestIntegerObject::class);
        $setOfThrees = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $setOfTwos->add(new TestIntegerObject($val));
        }

        foreach ($threes as $val) {
            $setOfThrees->add(new TestIntegerObject($val));
        }

        $validSet = [3, 9, 15, 21];
        $invalidSet = [6, 12, 18, 24, 30];
        $complement = $setOfTwos->complement($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$complement->contains(new TestIntegerObject($val))) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($complement->contains(new TestIntegerObject($val))) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_union_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(TestIntegerObject::class);
        $setOfThrees = SortedSet::comparable(TestIntegerObject::class);

        foreach ($twos as $val) {
            $setOfTwos->add(new TestIntegerObject($val));
        }

        foreach ($threes as $val) {
            $setOfThrees->add(new TestIntegerObject($val));
        }

        $validSet = [2, 3, 4, 6, 8, 9, 10, 12, 14, 15, 16, 18, 20, 21, 22, 24, 26, 28, 30];
        $invalidSet = [1, 5, 7, 11, 13, 17, 19, 23, 25, 27, 29];
        $union = $setOfTwos->union($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$union->contains(new TestIntegerObject($val))) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($union->contains(new TestIntegerObject($val))) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_range_returns_inclusive_set()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $days = $set->range(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $count = 0;

        foreach ($days as $day) {
            $count++;
        }

        static::assertSame(3, $count);
    }

    public function test_that_range_count_includes_item_arguments_when_present()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $count = $set->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());

        static::assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_item_arguments_when_missing()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $set->remove(TestWeekDay::THURSDAY());
        $count = $set->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());

        static::assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $count = $set->rangeCount(TestWeekDay::THURSDAY(), TestWeekDay::TUESDAY());

        static::assertSame(0, $count);
    }

    public function test_that_max_returns_expected_value()
    {
        $set = SortedSet::integer();
        $set->add(5356);
        $set->add(7489);
        $set->add(8936);

        static::assertSame(8936, $set->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(['age' => 32], $set->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $set = SortedSet::integer();
        $set->add(5356);
        $set->add(7489);
        $set->add(8936);

        static::assertSame(5356, $set->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(['age' => 19], $set->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_remove_min_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        for ($i = 0; $i < 6; $i++) {
            $set->removeMin();
        }

        static::assertTrue($set->contains(TestWeekDay::SATURDAY()));
    }

    public function test_that_remove_min_correctly_finds_and_removes_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);
        $set->removeMin(function (array $data) {
            return $data['age'];
        });

        static::assertFalse($set->contains(['age' => 19]));
    }

    public function test_that_remove_max_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        for ($i = 0; $i < 6; $i++) {
            $set->removeMax();
        }

        static::assertTrue($set->contains(TestWeekDay::SUNDAY()));
    }

    public function test_that_remove_max_correctly_finds_and_removes_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);
        $set->removeMax(function (array $data) {
            return $data['age'];
        });

        static::assertFalse($set->contains(['age' => 32]));
    }

    public function test_that_sum_returns_expected_value()
    {
        $set = SortedSet::integer();
        $set->add(1);
        $set->add(2);
        $set->add(3);

        static::assertSame(6, $set->sum());
    }

    public function test_that_sum_returns_null_with_empty_set()
    {
        static::assertNull(SortedSet::integer()->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(77, $set->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $set = SortedSet::float();
        $set->add(1.0);
        $set->add(2.0);
        $set->add(3.0);

        static::assertEquals(2.0, $set->average());
    }

    public function test_that_average_returns_null_with_empty_set()
    {
        static::assertNull(SortedSet::integer()->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $set = SortedSet::callback(function (array $item1, array $item2) {
            return $item1['age'] <=> $item2['age'];
        }, 'array');
        $set->add(['age' => 18]);
        $set->add(['age' => 31]);
        $set->add(['age' => 26]);

        static::assertEquals(25.0, $set->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_floor_returns_equal_item_when_present()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertTrue(TestWeekDay::FRIDAY()->equals($set->floor(TestWeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_item_equal_or_less_than_arg()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $set->remove(TestWeekDay::THURSDAY());

        static::assertTrue(TestWeekDay::WEDNESDAY()->equals($set->floor(TestWeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_item_not_found()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $set->remove(TestWeekDay::SUNDAY());

        static::assertNull($set->floor(TestWeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_item_when_present()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertTrue(TestWeekDay::MONDAY()->equals($set->ceiling(TestWeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_item_equal_or_greater_than_arg()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $set->remove(TestWeekDay::TUESDAY());

        static::assertTrue(TestWeekDay::WEDNESDAY()->equals($set->ceiling(TestWeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_item_not_found()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $set->remove(TestWeekDay::SATURDAY());

        static::assertNull($set->ceiling(TestWeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_item()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertSame(4, $set->rank(TestWeekDay::THURSDAY()));
    }

    public function test_that_select_returns_item_assoc_with_rank()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertTrue(TestWeekDay::THURSDAY()->equals($set->select(4)));
    }

    public function test_that_it_is_traversable()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $count = 0;

        foreach ($set as $item) {
            if ($item->value() !== $count) {
                throw new \Exception('Items out of order');
            }
            $count++;
        }

        static::assertSame(7, $count);
    }

    public function test_that_to_array_returns_expected_value()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        static::assertCount(7, $set->toArray());
    }

    public function test_that_clone_include_nested_collection()
    {
        $set = SortedSet::comparable(TestWeekDay::class);

        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }

        $copy = clone $set;

        while (!$set->isEmpty()) {
            $set->removeMin();
        }

        static::assertCount(7, $copy->toArray());
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $output = ArrayList::of('string');

        $set->each(function ($item) use ($output) {
            $output->add($item);
        });

        static::assertCount(3, $output->toArray());
    }

    public function test_that_map_returns_expected_set()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $output = $set->map(function ($item) {
            return strlen($item);
        }, new IntegerComparator(), 'int');

        $data = [];

        foreach ($output as $item) {
            $data[] = $item;
        }

        static::assertSame([3], $data);
    }

    public function test_that_find_returns_expected_item()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $item = $set->find(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertSame('bar', $item);
    }

    public function test_that_find_returns_null_when_item_not_found()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $item = $set->find(function ($item) {
            return substr($item, 0, 1) === 'c';
        });

        static::assertNull($item);
    }

    public function test_that_filter_returns_expected_set()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $output = $set->filter(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        $data = [];

        foreach ($output as $item) {
            $data[] = $item;
        }

        static::assertCount(2, $data);
    }

    public function test_that_reject_returns_expected_set()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $output = $set->reject(function ($item) {
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
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertTrue($set->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertFalse($set->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertTrue($set->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertFalse($set->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_sets()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $parts = $set->partition(function ($item) {
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

        static::assertTrue(count($data1) === 2 && count($data2) === 1);
    }

    public function test_that_to_json_returns_expected_value()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["bar","baz","foo"]', $set->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["bar","baz","foo"]', json_encode($set));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["bar","baz","foo"]', $set->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["bar","baz","foo"]', (string) $set);
    }

    public function test_that_comparable_triggers_assert_error_for_non_comparable_type()
    {
        $this->expectException(AssertionException::class);

        SortedSet::comparable('string');
    }

    protected function getWeekDays()
    {
        return [
            TestWeekDay::MONDAY(),
            TestWeekDay::WEDNESDAY(),
            TestWeekDay::FRIDAY(),
            TestWeekDay::TUESDAY(),
            TestWeekDay::THURSDAY(),
            TestWeekDay::SATURDAY(),
            TestWeekDay::SUNDAY()
        ];
    }
}
