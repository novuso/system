<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Collection\HashSet;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\HashSet
 */
class HashSetTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(HashSet::of('string')->isEmpty());
    }

    public function test_that_duplicate_items_do_not_affect_count()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('foo');

        static::assertSame(2, count($set));
    }

    public function test_that_contains_returns_true_when_item_is_in_the_set()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');

        static::assertTrue($set->contains('bar'));
    }

    public function test_that_contains_returns_false_when_item_is_not_in_the_set()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');

        static::assertFalse($set->contains('baz'));
    }

    public function test_that_contains_returns_false_after_item_is_removed()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->remove('foo');

        static::assertFalse($set->contains('foo'));
    }

    public function test_that_difference_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = HashSet::of('int');

        foreach ($twos as $val) {
            $set->add($val);
        }

        $difference = $set->difference($set);

        static::assertTrue($difference->isEmpty());
    }

    public function test_that_difference_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = HashSet::of('int');
        $setOfThrees = HashSet::of('int');

        foreach ($twos as $val) {
            $setOfTwos->add($val);
        }

        foreach ($threes as $val) {
            $setOfThrees->add($val);
        }

        $validSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $invalidSet = [6, 12, 18, 24, 30];
        $difference = $setOfTwos->difference($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$difference->contains($val)) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($difference->contains($val)) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_intersection_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = HashSet::of('int');
        $setOfThrees = HashSet::of('int');

        foreach ($twos as $val) {
            $setOfTwos->add($val);
        }

        foreach ($threes as $val) {
            $setOfThrees->add($val);
        }

        $validSet = [6, 12, 18, 24, 30];
        $invalidSet = [2, 3, 4, 8, 9, 10, 14, 15, 16, 20, 21, 22, 26, 28];
        $intersection = $setOfTwos->intersection($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$intersection->contains($val)) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($intersection->contains($val)) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_complement_returns_empty_set_from_same_instances()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $set = HashSet::of('int');

        foreach ($twos as $val) {
            $set->add($val);
        }

        $complement = $set->complement($set);

        static::assertTrue($complement->isEmpty());
    }

    public function test_that_complement_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = HashSet::of('int');
        $setOfThrees = HashSet::of('int');

        foreach ($twos as $val) {
            $setOfTwos->add($val);
        }

        foreach ($threes as $val) {
            $setOfThrees->add($val);
        }

        $validSet = [3, 9, 15, 21];
        $invalidSet = [6, 12, 18, 24, 30];
        $complement = $setOfTwos->complement($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$complement->contains($val)) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($complement->contains($val)) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_union_returns_expected_set()
    {
        $twos = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
        $threes = [3, 6, 9, 12, 15, 18, 21, 24, 30];
        $setOfTwos = HashSet::of('int');
        $setOfThrees = HashSet::of('int');

        foreach ($twos as $val) {
            $setOfTwos->add($val);
        }

        foreach ($threes as $val) {
            $setOfThrees->add($val);
        }

        $validSet = [2, 3, 4, 6, 8, 9, 10, 12, 14, 15, 16, 18, 20, 21, 22, 24, 26, 28, 30];
        $invalidSet = [1, 5, 7, 11, 13, 17, 19, 23, 25, 27, 29];
        $union = $setOfTwos->union($setOfThrees);
        $valid = true;

        foreach ($validSet as $val) {
            if (!$union->contains($val)) {
                $valid = false;
            }
        }

        foreach ($invalidSet as $val) {
            if ($union->contains($val)) {
                $value = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $set = HashSet::of('string');
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
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $output = $set->map(function ($item) {
            return strlen($item);
        }, 'int');

        $data = [];

        foreach ($output as $item) {
            $data[] = $item;
        }

        static::assertSame([3], $data);
    }

    public function test_that_max_returns_expected_value()
    {
        $set = HashSet::of('int');
        $set->add(5356);
        $set->add(7489);
        $set->add(8936);

        static::assertSame(8936, $set->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $set = HashSet::of('array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(['age' => 32], $set->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $set = HashSet::of('int');
        $set->add(5356);
        $set->add(7489);
        $set->add(8936);

        static::assertSame(5356, $set->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $set = HashSet::of('array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(['age' => 19], $set->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $set = HashSet::of('int');
        $set->add(1);
        $set->add(2);
        $set->add(3);

        static::assertSame(6, $set->sum());
    }

    public function test_that_sum_returns_null_with_empty_set()
    {
        static::assertNull(HashSet::of('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $set = HashSet::of('array');
        $set->add(['age' => 19]);
        $set->add(['age' => 32]);
        $set->add(['age' => 26]);

        static::assertSame(77, $set->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $set = HashSet::of('int');
        $set->add(1);
        $set->add(2);
        $set->add(3);

        static::assertEquals(2.0, $set->average());
    }

    public function test_that_average_returns_null_with_empty_set()
    {
        static::assertNull(HashSet::of('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $set = HashSet::of('array');
        $set->add(['age' => 18]);
        $set->add(['age' => 31]);
        $set->add(['age' => 26]);

        static::assertEquals(25.0, $set->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_find_returns_expected_item()
    {
        $set = HashSet::of('string');
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
        $set = HashSet::of('string');
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
        $set = HashSet::of('string');
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
        $set = HashSet::of('string');
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
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertTrue($set->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertFalse($set->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertTrue($set->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertFalse($set->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_sets()
    {
        $set = HashSet::of('string');
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

    public function test_to_array_returns_expected_value()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        $items = ['foo', 'bar', 'baz'];
        $array = $set->toArray();

        static::assertTrue(
            in_array('foo', $array)
            && in_array('bar', $array)
            && in_array('baz', $array)
        );
    }

    public function test_that_to_json_returns_expected_value()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["foo","bar","baz"]', $set->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["foo","bar","baz"]', json_encode($set));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["foo","bar","baz"]', $set->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $set = HashSet::of('string');
        $set->add('foo');
        $set->add('bar');
        $set->add('baz');

        static::assertSame('["foo","bar","baz"]', (string) $set);
    }

    public function test_that_clone_include_nested_collection()
    {
        $set = HashSet::of('int');
        $items = range(0, 9);

        foreach ($items as $i) {
            $set->add($i);
        }

        $copy = clone $set;

        foreach ($items as $i) {
            $set->remove($i);
        }

        static::assertSame($items, $copy->toArray());
    }

    public function test_that_add_triggers_assert_error_for_invalid_item_type()
    {
        $this->expectException(AssertionException::class);

        HashSet::of('int')->add('string');
    }
}
