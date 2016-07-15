<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Collection\Compare\IntegerComparator;
use Novuso\System\Collection\SortedSet;
use Novuso\Test\System\Resources\IntegerObject;
use Novuso\Test\System\Resources\WeekDay;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Collection\SortedSet
 */
class SortedSetTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(SortedSet::comparable(WeekDay::class)->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertCount(7, $set);
    }

    public function test_that_duplicate_items_are_overridden()
    {
        $set = SortedSet::comparable(WeekDay::class);
        $set->add(WeekDay::TUESDAY());
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertCount(7, $set);
    }

    public function test_that_contains_returns_true_for_valid_item()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertTrue($set->contains(WeekDay::SATURDAY()));
    }

    public function test_that_remove_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        foreach ($this->getWeekDays() as $weekDay) {
            $set->remove($weekDay);
        }
        $this->assertTrue($set->isEmpty());
    }

    public function test_that_difference_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $set->add(new IntegerObject($val));
        }
        $difference = $set->difference($set);
        $this->assertTrue($difference->isEmpty());
    }

    public function test_that_difference_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(IntegerObject::class);
        $setOfThrees = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $setOfTwos->add(new IntegerObject($val));
        }
        foreach ($threes as $val) {
            $setOfThrees->add(new IntegerObject($val));
        }
        $validSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $invalidSet = [6, 12, 18, 24, 30];
        $difference = $setOfTwos->difference($setOfThrees);
        $valid = true;
        foreach ($validSet as $val) {
            if (!$difference->contains(new IntegerObject($val))) {
                $valid = false;
            }
        }
        foreach ($invalidSet as $val) {
            if ($difference->contains(new IntegerObject($val))) {
                $value = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_that_intersection_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(IntegerObject::class);
        $setOfThrees = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $setOfTwos->add(new IntegerObject($val));
        }
        foreach ($threes as $val) {
            $setOfThrees->add(new IntegerObject($val));
        }
        $validSet = [6, 12, 18, 24, 30];
        $invalidSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $intersection = $setOfTwos->intersection($setOfThrees);
        $valid = true;
        foreach ($validSet as $val) {
            if (!$intersection->contains(new IntegerObject($val))) {
                $valid = false;
            }
        }
        foreach ($invalidSet as $val) {
            if ($intersection->contains(new IntegerObject($val))) {
                $value = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_that_complement_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $set->add(new IntegerObject($val));
        }
        $complement = $set->complement($set);
        $this->assertTrue($complement->isEmpty());
    }

    public function test_that_complement_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(IntegerObject::class);
        $setOfThrees = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $setOfTwos->add(new IntegerObject($val));
        }
        foreach ($threes as $val) {
            $setOfThrees->add(new IntegerObject($val));
        }
        $validSet = [3, 9, 15, 21];
        $invalidSet = [6, 12, 18, 24, 30];
        $complement = $setOfTwos->complement($setOfThrees);
        $valid = true;
        foreach ($validSet as $val) {
            if (!$complement->contains(new IntegerObject($val))) {
                $valid = false;
            }
        }
        foreach ($invalidSet as $val) {
            if ($complement->contains(new IntegerObject($val))) {
                $value = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_that_union_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = SortedSet::comparable(IntegerObject::class);
        $setOfThrees = SortedSet::comparable(IntegerObject::class);
        foreach ($twos as $val) {
            $setOfTwos->add(new IntegerObject($val));
        }
        foreach ($threes as $val) {
            $setOfThrees->add(new IntegerObject($val));
        }
        $validSet = [2, 3, 4, 6, 8, 9, 10, 12, 14, 15, 16, 18, 20, 21, 22, 24, 26, 28, 30];
        $invalidSet = [1, 5, 7, 11, 13, 17, 19, 23, 25, 27, 29];
        $union = $setOfTwos->union($setOfThrees);
        $valid = true;
        foreach ($validSet as $val) {
            if (!$union->contains(new IntegerObject($val))) {
                $valid = false;
            }
        }
        foreach ($invalidSet as $val) {
            if ($union->contains(new IntegerObject($val))) {
                $value = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_that_range_returns_inclusive_set()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $days = $set->range(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $count = 0;
        foreach ($days as $day) {
            $count++;
        }
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_includes_item_arguments_when_present()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $count = $set->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_item_arguments_when_missing()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $set->remove(WeekDay::THURSDAY());
        $count = $set->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $count = $set->rangeCount(WeekDay::THURSDAY(), WeekDay::TUESDAY());
        $this->assertSame(0, $count);
    }

    public function test_that_min_returns_expected_item()
    {
        $items = [21.6, 14.7, 0.13, 17.17, 0.034, 3.171, 54.01, 0.27, 1.78];
        $set = SortedSet::float();
        foreach ($items as $item) {
            $set->add($item);
        }
        $this->assertSame(0.034, $set->min());
    }

    public function test_that_max_returns_expected_item()
    {
        $items = [21, 14, 10, 17, 0, 37, 54, 27, 18];
        $set = SortedSet::integer();
        foreach ($items as $item) {
            $set->add($item);
        }
        $this->assertSame(54, $set->max());
    }

    public function test_that_remove_min_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        for ($i = 0; $i < 6; $i++) {
            $set->removeMin();
        }
        $this->assertTrue($set->contains(WeekDay::SATURDAY()));
    }

    public function test_that_remove_max_correctly_finds_and_removes()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        for ($i = 0; $i < 6; $i++) {
            $set->removeMax();
        }
        $this->assertTrue($set->contains(WeekDay::SUNDAY()));
    }

    public function test_that_floor_returns_equal_item_when_present()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertTrue(WeekDay::FRIDAY()->equals($set->floor(WeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_item_equal_or_less_than_arg()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $set->remove(WeekDay::THURSDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($set->floor(WeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_item_not_found()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $set->remove(WeekDay::SUNDAY());
        $this->assertNull($set->floor(WeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_item_when_present()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertTrue(WeekDay::MONDAY()->equals($set->ceiling(WeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_item_equal_or_greater_than_arg()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $set->remove(WeekDay::TUESDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($set->ceiling(WeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_item_not_found()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $set->remove(WeekDay::SATURDAY());
        $this->assertNull($set->ceiling(WeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_item()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertSame(4, $set->rank(WeekDay::THURSDAY()));
    }

    public function test_that_select_returns_item_assoc_with_rank()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertTrue(WeekDay::THURSDAY()->equals($set->select(4)));
    }

    public function test_that_it_is_traversable()
    {
        $set = SortedSet::comparable(WeekDay::class);
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
        $this->assertSame(7, $count);
    }

    public function test_that_to_array_returns_expected_value()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $this->assertCount(7, $set->toArray());
    }

    public function test_that_clone_include_nested_collection()
    {
        $set = SortedSet::comparable(WeekDay::class);
        foreach ($this->getWeekDays() as $weekDay) {
            $set->add($weekDay);
        }
        $copy = clone $set;
        while (!$set->isEmpty()) {
            $set->removeMin();
        }
        $this->assertCount(7, $copy->toArray());
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
        $this->assertCount(3, $output->toArray());
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
        $this->assertSame([3], $data);
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
        $this->assertSame('bar', $item);
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
        $this->assertNull($item);
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
        $this->assertCount(2, $data);
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
        $this->assertSame(['foo'], $data);
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');
        $this->assertTrue($set->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');
        $this->assertFalse($set->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');
        $this->assertTrue($set->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $set = SortedSet::string();
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');
        $this->assertFalse($set->every(function ($item) {
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
        $this->assertTrue(count($data1) === 2 && count($data2) === 1);
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_comparable_triggers_assert_error_for_non_comparable_type()
    {
        SortedSet::comparable('string');
    }

    protected function getWeekDays()
    {
        return [
            WeekDay::MONDAY(),
            WeekDay::WEDNESDAY(),
            WeekDay::FRIDAY(),
            WeekDay::TUESDAY(),
            WeekDay::THURSDAY(),
            WeekDay::SATURDAY(),
            WeekDay::SUNDAY()
        ];
    }
}
