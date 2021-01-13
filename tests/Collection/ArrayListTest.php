<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\Resources\TestUser;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\ArrayList
 * @covers \Novuso\System\Collection\Traits\ItemTypeMethods
 */
class ArrayListTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        static::assertTrue(ArrayList::of('string')->isEmpty());
    }

    public function test_that_added_items_affect_count()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('foo');

        static::assertSame(3, count($list));
    }

    public function test_that_added_items_affect_length()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('foo');

        static::assertSame(3, $list->length());
    }

    public function test_that_replace_returns_expected_instance()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertSame(['one', 'two', 'three'], $list->replace(['one', 'two', 'three'])->toArray());
    }

    public function test_that_set_replaces_item_at_an_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->set(1, 'baz');

        static::assertSame(2, count($list));
    }

    public function test_that_set_replaces_item_at_a_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->set(-1, 'baz');

        static::assertSame('baz', $list->get(1));
    }

    public function test_that_get_returns_item_at_pos_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertSame('bar', $list->get(1));
    }

    public function test_that_get_returns_item_at_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertSame('bar', $list->get(-2));
    }

    public function test_that_has_returns_true_for_index_in_bounds()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertTrue($list->has(2));
    }

    public function test_that_has_returns_false_for_index_out_of_bounds()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertFalse($list->has(4));
    }

    public function test_that_remove_deletes_item_and_reindexes_list()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(1);

        static::assertSame('baz', $list->get(1));
    }

    public function test_that_remove_deletes_correct_item_at_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(-2);

        static::assertSame('baz', $list->get(1));
    }

    public function test_that_remove_fails_silently_at_out_of_bounds_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(4);

        static::assertSame(3, count($list));
    }

    public function test_that_contains_returns_true_when_item_is_present_strong_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);

        static::assertTrue($list->contains(2));
    }

    public function test_that_contains_returns_false_when_item_is_not_present_strong_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);

        static::assertFalse($list->contains(5));
    }

    public function test_that_contains_returns_false_when_item_is_present_different_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);

        static::assertFalse($list->contains('2'));
    }

    public function test_that_contains_returns_true_when_item_is_present_weak_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);

        static::assertTrue($list->contains('2', $strict = false));
    }

    public function test_that_offset_set_adds_item_when_used_without_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';

        static::assertSame('bar', $list[1]);
    }

    public function test_that_offset_set_replaces_item_at_given_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[1] = 'baz';

        static::assertSame(2, count($list));
    }

    public function test_that_offset_exists_returns_true_for_index_in_bounds()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';

        static::assertTrue(isset($list[1]));
    }

    public function test_that_offset_exists_returns_false_for_index_out_of_bounds()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';

        static::assertFalse(isset($list[2]));
    }

    public function test_that_offset_unset_deletes_item_and_reindexes_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        unset($list[1]);

        static::assertSame('baz', $list[1]);
    }

    public function test_that_sort_correctly_sorts_items()
    {
        $items = [
            942, 510, 256, 486, 985, 152, 385, 836, 907, 499, 519, 194, 832, 42, 246, 409, 886, 555, 561, 209,
            865, 125, 385, 568, 35, 491, 974, 784, 980, 800, 591, 884, 648, 971, 583, 359, 907, 758, 438, 34,
            398, 855, 364, 236, 817, 548, 518, 369, 817, 887, 559, 941, 653, 421, 19, 71, 608, 316, 151, 296,
            831, 807, 744, 513, 668, 373, 255, 49, 29, 674, 911, 700, 486, 14, 323, 388, 164, 786, 702, 273,
            207, 25, 809, 635, 68, 134, 86, 744, 486, 657, 155, 445, 702, 78, 558, 17, 394, 247, 171, 236
        ];

        $list = ArrayList::of('int');

        foreach ($items as $item) {
            $list->add($item);
        }

        $list = $list->sort(function ($a, $b) {
            if ($a > $b) {
                return -1;
            }
            if ($a < $b) {
                return 1;
            }

            return 0;
        });

        $reverse = $items;
        rsort($reverse);

        static::assertSame($reverse, $list->toArray());
    }

    public function test_stable_sort_keeps_order_of_already_sorted_array()
    {
        $records = $this->getUserDataSortedByLastName();

        $list = ArrayList::of(TestUser::class);

        foreach ($records as $record) {
            $list[] = new TestUser($record);
        }

        $list = $list->sort(function (TestUser $user1, TestUser $user2) {
            $comp = strnatcmp($user1->lastName(), $user2->lastName());

            return $comp <=> 0;
        });

        $sorted = $this->getUserDataSortedByLastName();
        $valid = true;
        $count = count($list);

        for ($i = 0; $i < $count; $i++) {
            $user = $list[$i];
            if ($user->lastName() !== $sorted[$i]['lastName']) {
                $valid = false;
            }
        }

        static::assertTrue($valid);
    }

    public function test_that_reverse_returns_expected_instance()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');

        static::assertSame(['baz', 'bar', 'foo'], $list->reverse()->toArray());
    }

    public function test_that_head_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('foo', $list->head());
    }

    public function test_that_tail_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame(['bar', 'baz'], $list->tail()->toArray());
    }

    public function test_that_first_returns_default_when_empty_no_predicate()
    {
        static::assertSame('default', ArrayList::of('string')->first(null, 'default'));
    }

    public function test_that_first_returns_default_when_empty()
    {
        static::assertSame('default', ArrayList::of('string')->first(function (string $item) {
            return str_contains($item, '@');
        }, 'default'));
    }

    public function test_that_first_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('foo', $list->first());
    }

    public function test_that_first_returns_expected_item_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('bar', $list->first(function (string $item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_last_returns_default_when_empty_no_predicate()
    {
        static::assertSame('default', ArrayList::of('string')->last(null, 'default'));
    }

    public function test_that_last_returns_default_when_empty()
    {
        static::assertSame('default', ArrayList::of('string')->last(function (string $item) {
            return str_contains($item, '@');
        }, 'default'));
    }

    public function test_that_last_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('baz', $list->last());
    }

    public function test_that_last_returns_expected_item_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('baz', $list->last(function (string $item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_index_of_returns_expected_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame(1, $list->indexOf('bar'));
    }

    public function test_that_index_of_returns_null_when_item_not_found()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertNull($list->indexOf('buz'));
    }

    public function test_that_index_of_returns_expected_index_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame(1, $list->indexOf(function (string $item) {
            return $item === 'bar';
        }));
    }

    public function test_that_index_of_returns_null_when_item_not_found_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertNull($list->indexOf(function (string $item) {
            return $item === 'buz';
        }));
    }

    public function test_that_last_index_of_returns_expected_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'bar';

        static::assertSame(3, $list->lastIndexOf('bar'));
    }

    public function test_that_last_index_of_returns_null_when_item_not_found()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertNull($list->lastIndexOf('buz'));
    }

    public function test_that_last_index_of_returns_expected_index_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'bar';

        static::assertSame(3, $list->lastIndexOf(function (string $item) {
            return $item === 'bar';
        }));
    }

    public function test_that_last_index_of_returns_null_when_item_not_found_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertNull($list->lastIndexOf(function (string $item) {
            return $item === 'buz';
        }));
    }

    public function test_that_it_is_iterable_forward()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        for ($list->rewind(); $list->valid(); $list->next()) {
            if ($list->key() === 1) {
                static::assertSame('bar', $list->current());
            }
        }
    }

    public function test_that_it_is_iterable_in_reverse()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        for ($list->end(); $list->valid(); $list->prev()) {
            if ($list->key() === 1) {
                static::assertSame('bar', $list->current());
            }
        }
    }

    public function test_that_it_is_directly_traversable()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        foreach ($list as $index => $item) {
            if ($index === 1) {
                static::assertSame('bar', $item);
            }
        }
    }

    public function test_that_unique_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'bar';
        $list[] = 'foo';
        $list[] = 'baz';
        $list[] = 'bar';
        $list[] = 'foo';

        static::assertSame(['bar', 'foo', 'baz'], $list->unique()->toArray());
    }

    public function test_that_unique_returns_expected_list_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'bar';
        $list[] = 'foo';
        $list[] = 'baz';
        $list[] = 'bar';
        $list[] = 'foo';

        static::assertSame(['bar', 'foo'], $list->unique(function (string $item) {
            return substr($item, 0, 1);
        })->toArray());
    }

    public function test_that_slice_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame(['bar', 'baz', 'foo'], $list->slice(1, 3)->toArray());
    }

    public function test_that_page_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame(['foo', 'bar', 'baz'], $list->page(2, 3)->toArray());
    }

    public function test_that_max_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 5356;
        $list[] = 7489;
        $list[] = 8936;
        $list[] = 2345;

        static::assertSame(8936, $list->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];

        static::assertSame(['age' => 32], $list->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 5356;
        $list[] = 7489;
        $list[] = 8936;
        $list[] = 2345;

        static::assertSame(2345, $list->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];

        static::assertSame(['age' => 19], $list->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 1;
        $list[] = 2;
        $list[] = 3;

        static::assertSame(6, $list->sum());
    }

    public function test_that_sum_returns_null_with_empty_list()
    {
        static::assertNull(ArrayList::of('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];

        static::assertSame(77, $list->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 1;
        $list[] = 2;
        $list[] = 3;

        static::assertEquals(2.0, $list->average());
    }

    public function test_that_average_returns_null_with_empty_list()
    {
        static::assertNull(ArrayList::of('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 18];
        $list[] = ['age' => 31];
        $list[] = ['age' => 26];

        static::assertEquals(25.0, $list->average(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_clone_include_nested_collection()
    {
        $list = ArrayList::of('int');
        $items = range(0, 9);

        foreach ($items as $num) {
            $list->add($num);
        }

        $copy = clone $list;

        for ($i = 0; $i < 9; $i++) {
            $list->remove($i);
        }

        static::assertSame($items, $copy->toArray());
    }

    public function test_that_calling_key_without_valid_item_returns_null()
    {
        $list = ArrayList::of('string');

        static::assertNull($list->key());
    }

    public function test_that_calling_current_without_valid_item_returns_null()
    {
        $list = ArrayList::of('string');

        static::assertNull($list->current());
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $output = ArrayList::of('string');

        $list->each(function ($item) use ($output) {
            $output->add($item);
        });

        static::assertSame(['foo', 'bar', 'baz'], $output->toArray());
    }

    public function test_that_map_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $output = $list->map(function ($item) {
            return strlen($item);
        }, 'int');

        static::assertSame([3, 3, 3], $output->toArray());
    }

    public function test_that_find_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $item = $list->find(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertSame('bar', $item);
    }

    public function test_that_find_returns_null_when_item_not_found()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $item = $list->find(function ($item) {
            return substr($item, 0, 1) === 'c';
        });

        static::assertNull($item);
    }

    public function test_that_filter_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $output = $list->filter(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertSame(['bar', 'baz'], $output->toArray());
    }

    public function test_that_reject_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $output = $list->reject(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertSame(['foo'], $output->toArray());
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertTrue($list->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertFalse($list->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertTrue($list->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertFalse($list->every(function ($item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_partition_returns_expected_lists()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        $parts = $list->partition(function ($item) {
            return substr($item, 0, 1) === 'b';
        });

        static::assertTrue($parts[0]->toArray() === ['bar', 'baz'] && $parts[1]->toArray() === ['foo']);
    }

    public function test_that_to_json_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('["foo","bar","baz"]', $list->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('["foo","bar","baz"]', json_encode($list));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('["foo","bar","baz"]', $list->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';

        static::assertSame('["foo","bar","baz"]', (string) $list);
    }

    public function test_that_head_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);

        ArrayList::of('string')->head();
    }

    public function test_that_tail_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);

        ArrayList::of('string')->tail();
    }

    public function test_that_add_triggers_assert_error_for_invalid_item_type()
    {
        $this->expectException(AssertionException::class);

        ArrayList::of('object')->add('string');
    }

    public function test_that_set_triggers_assert_error_for_invalid_item_type()
    {
        $this->expectException(AssertionException::class);

        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->set(0, 'string');
    }

    public function test_that_offset_set_triggers_assert_error_for_invalid_index_type()
    {
        $this->expectException(AssertionException::class);

        $list = ArrayList::of('string');
        $list['foo'] = 'bar';
    }

    public function test_that_offset_get_triggers_assert_error_for_invalid_index_type()
    {
        $this->expectException(AssertionException::class);

        $list = ArrayList::of('string');
        $list->add('foo');
        $list['foo'];
    }

    public function test_that_offset_exists_triggers_assert_error_for_invalid_index_type()
    {
        $this->expectException(AssertionException::class);

        $list = ArrayList::of('string');
        $list->add('foo');
        isset($list['foo']);
    }

    public function test_that_offset_unset_triggers_assert_error_for_invalid_index_type()
    {
        $this->expectException(AssertionException::class);

        $list = ArrayList::of('string');
        $list->add('foo');
        unset($list['foo']);
    }

    public function test_that_set_throws_exception_for_invalid_index()
    {
        $this->expectException(IndexException::class);

        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->set(1, new \stdClass());
    }

    public function test_that_get_throws_exception_for_invalid_index()
    {
        $this->expectException(IndexException::class);

        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->get(1);
    }

    protected function getUserDataSortedByLastName()
    {
        $data = $this->getUserDataUnsorted();

        usort($data, function ($user1, $user2) {
            return strnatcmp($user1["lastName"], $user2["lastName"]);
        });

        return $data;
    }

    protected function getUserDataUnsorted()
    {
        return [
            [
                "lastName"  => "Swaniawski",
                "firstName" => "Alexandria",
                "username"  => "swaniawski.alexandria",
                "email"     => "swaniawski.alexandria@example.com",
                "birthDate" => "1963-02-08 19:45:59"
            ],
            [
                "lastName"  => "Christiansen",
                "firstName" => "Vernice",
                "username"  => "christiansen.vernice",
                "email"     => "christiansen.vernice@example.com",
                "birthDate" => "1984-10-18 00:30:16"
            ],
            [
                "lastName"  => "Stanton",
                "firstName" => "Lilyan",
                "username"  => "stanton.lilyan",
                "email"     => "stanton.lilyan@example.net",
                "birthDate" => "1982-08-13 18:21:53"
            ],
            [
                "lastName"  => "Hermiston",
                "firstName" => "Michele",
                "username"  => "hermiston.michele",
                "email"     => "hermiston.michele@example.org",
                "birthDate" => "1961-04-06 14:35:45"
            ],
            [
                "lastName"  => "Botsford",
                "firstName" => "Anya",
                "username"  => "botsford.anya",
                "email"     => "botsford.anya@example.net",
                "birthDate" => "1957-11-29 15:17:17"
            ],
            [
                "lastName"  => "Gerlach",
                "firstName" => "Martin",
                "username"  => "gerlach.martin",
                "email"     => "gerlach.martin@example.net",
                "birthDate" => "1967-09-25 06:05:09"
            ],
            [
                "lastName"  => "Quigley",
                "firstName" => "Jarred",
                "username"  => "quigley.jarred",
                "email"     => "quigley.jarred@example.net",
                "birthDate" => "1994-02-25 01:54:42"
            ],
            [
                "lastName"  => "Effertz",
                "firstName" => "Christine",
                "username"  => "effertz.christine",
                "email"     => "effertz.christine@example.com",
                "birthDate" => "1971-07-26 07:30:44"
            ],
            [
                "lastName"  => "Green",
                "firstName" => "Frances",
                "username"  => "green.frances",
                "email"     => "green.frances@example.org",
                "birthDate" => "1979-04-04 11:03:31"
            ],
            [
                "lastName"  => "Pollich",
                "firstName" => "Beth",
                "username"  => "pollich.beth",
                "email"     => "pollich.beth@example.com",
                "birthDate" => "1996-04-27 05:21:32"
            ],
            [
                "lastName"  => "Walsh",
                "firstName" => "Sedrick",
                "username"  => "walsh.sedrick",
                "email"     => "walsh.sedrick@example.org",
                "birthDate" => "1943-10-10 03:57:25"
            ],
            [
                "lastName"  => "Crooks",
                "firstName" => "Luella",
                "username"  => "crooks.luella",
                "email"     => "crooks.luella@example.com",
                "birthDate" => "2004-11-28 05:34:33"
            ],
            [
                "lastName"  => "Feil",
                "firstName" => "Jack",
                "username"  => "feil.jack",
                "email"     => "feil.jack@example.net",
                "birthDate" => "1976-11-16 21:29:22"
            ],
            [
                "lastName"  => "Braun",
                "firstName" => "Kurtis",
                "username"  => "braun.kurtis",
                "email"     => "braun.kurtis@example.net",
                "birthDate" => "1962-04-22 17:53:21"
            ],
            [
                "lastName"  => "Spinka",
                "firstName" => "Serenity",
                "username"  => "spinka.serenity",
                "email"     => "spinka.serenity@example.com",
                "birthDate" => "1963-07-29 04:08:31"
            ],
            [
                "lastName"  => "Fahey",
                "firstName" => "Hallie",
                "username"  => "fahey.hallie",
                "email"     => "fahey.hallie@example.com",
                "birthDate" => "1996-08-16 20:12:22"
            ],
            [
                "lastName"  => "Harber",
                "firstName" => "Giovanna",
                "username"  => "harber.giovanna",
                "email"     => "harber.giovanna@example.com",
                "birthDate" => "1965-08-01 16:03:31"
            ],
            [
                "lastName"  => "Mitchell",
                "firstName" => "Bridgette",
                "username"  => "mitchell.bridgette",
                "email"     => "mitchell.bridgette@example.net",
                "birthDate" => "1961-05-24 19:21:33"
            ],
            [
                "lastName"  => "Dietrich",
                "firstName" => "Retta",
                "username"  => "dietrich.retta",
                "email"     => "dietrich.retta@example.com",
                "birthDate" => "2003-03-06 00:55:31"
            ],
            [
                "lastName"  => "Pagac",
                "firstName" => "Destany",
                "username"  => "pagac.destany",
                "email"     => "pagac.destany@example.net",
                "birthDate" => "2003-08-25 13:45:00"
            ],
            [
                "lastName"  => "Sanford",
                "firstName" => "Porter",
                "username"  => "sanford.porter",
                "email"     => "sanford.porter@example.org",
                "birthDate" => "1938-10-29 14:02:38"
            ],
            [
                "lastName"  => "Breitenberg",
                "firstName" => "Gerardo",
                "username"  => "breitenberg.gerardo",
                "email"     => "breitenberg.gerardo@example.net",
                "birthDate" => "1959-05-20 09:45:16"
            ],
            [
                "lastName"  => "Heller",
                "firstName" => "Ebony",
                "username"  => "heller.ebony",
                "email"     => "heller.ebony@example.com",
                "birthDate" => "1938-10-14 19:28:52"
            ],
            [
                "lastName"  => "Howell",
                "firstName" => "Vladimir",
                "username"  => "howell.vladimir",
                "email"     => "howell.vladimir@example.net",
                "birthDate" => "1961-07-07 10:15:13"
            ],
            [
                "lastName"  => "Gaylord",
                "firstName" => "Zander",
                "username"  => "gaylord.zander",
                "email"     => "gaylord.zander@example.net",
                "birthDate" => "1926-05-05 19:55:40"
            ],
            [
                "lastName"  => "Hamill",
                "firstName" => "Stephan",
                "username"  => "hamill.stephan",
                "email"     => "hamill.stephan@example.org",
                "birthDate" => "1963-07-03 18:46:59"
            ],
            [
                "lastName"  => "Towne",
                "firstName" => "Dedrick",
                "username"  => "towne.dedrick",
                "email"     => "towne.dedrick@example.com",
                "birthDate" => "1949-03-29 07:32:49"
            ],
            [
                "lastName"  => "Hamill",
                "firstName" => "Harrison",
                "username"  => "hamill.harrison",
                "email"     => "hamill.harrison@example.net",
                "birthDate" => "1937-09-09 17:31:45"
            ],
            [
                "lastName"  => "Nienow",
                "firstName" => "Colten",
                "username"  => "nienow.colten",
                "email"     => "nienow.colten@example.org",
                "birthDate" => "1979-04-06 09:10:33"
            ],
            [
                "lastName"  => "Borer",
                "firstName" => "Myriam",
                "username"  => "borer.myriam",
                "email"     => "borer.myriam@example.org",
                "birthDate" => "1951-09-17 22:29:04"
            ],
            [
                "lastName"  => "Howe",
                "firstName" => "Tavares",
                "username"  => "howe.tavares",
                "email"     => "howe.tavares@example.org",
                "birthDate" => "1919-11-08 01:30:00"
            ],
            [
                "lastName"  => "Dietrich",
                "firstName" => "Agustina",
                "username"  => "dietrich.agustina",
                "email"     => "dietrich.agustina@example.com",
                "birthDate" => "1983-03-20 20:38:50"
            ],
            [
                "lastName"  => "Kautzer",
                "firstName" => "Vincenza",
                "username"  => "kautzer.vincenza",
                "email"     => "kautzer.vincenza@example.org",
                "birthDate" => "2011-07-27 10:45:35"
            ],
            [
                "lastName"  => "Cassin",
                "firstName" => "Evie",
                "username"  => "cassin.evie",
                "email"     => "cassin.evie@example.com",
                "birthDate" => "1959-06-02 21:14:33"
            ],
            [
                "lastName"  => "Rowe",
                "firstName" => "Percy",
                "username"  => "rowe.percy",
                "email"     => "rowe.percy@example.org",
                "birthDate" => "1925-12-15 01:37:08"
            ],
            [
                "lastName"  => "Kreiger",
                "firstName" => "Horace",
                "username"  => "kreiger.horace",
                "email"     => "kreiger.horace@example.com",
                "birthDate" => "1932-08-12 16:36:08"
            ],
            [
                "lastName"  => "Emmerich",
                "firstName" => "Gisselle",
                "username"  => "emmerich.gisselle",
                "email"     => "emmerich.gisselle@example.net",
                "birthDate" => "1978-01-23 03:40:38"
            ],
            [
                "lastName"  => "Macejkovic",
                "firstName" => "Travis",
                "username"  => "macejkovic.travis",
                "email"     => "macejkovic.travis@example.net",
                "birthDate" => "1930-08-09 08:59:07"
            ],
            [
                "lastName"  => "Weimann",
                "firstName" => "Berry",
                "username"  => "weimann.berry",
                "email"     => "weimann.berry@example.org",
                "birthDate" => "1965-03-17 20:17:16"
            ],
            [
                "lastName"  => "Schuppe",
                "firstName" => "Obie",
                "username"  => "schuppe.obie",
                "email"     => "schuppe.obie@example.net",
                "birthDate" => "1988-01-25 23:59:30"
            ],
            [
                "lastName"  => "Konopelski",
                "firstName" => "Price",
                "username"  => "konopelski.price",
                "email"     => "konopelski.price@example.com",
                "birthDate" => "1922-12-20 06:02:50"
            ],
            [
                "lastName"  => "Doyle",
                "firstName" => "Wava",
                "username"  => "doyle.wava",
                "email"     => "doyle.wava@example.com",
                "birthDate" => "1972-01-27 21:55:45"
            ],
            [
                "lastName"  => "Okuneva",
                "firstName" => "Melvina",
                "username"  => "okuneva.melvina",
                "email"     => "okuneva.melvina@example.com",
                "birthDate" => "1996-11-13 19:13:52"
            ],
            [
                "lastName"  => "Halvorson",
                "firstName" => "Chauncey",
                "username"  => "halvorson.chauncey",
                "email"     => "halvorson.chauncey@example.net",
                "birthDate" => "2010-04-06 23:42:49"
            ],
            [
                "lastName"  => "Morissette",
                "firstName" => "Federico",
                "username"  => "morissette.federico",
                "email"     => "morissette.federico@example.com",
                "birthDate" => "1924-01-08 20:04:24"
            ],
            [
                "lastName"  => "Rolfson",
                "firstName" => "Wellington",
                "username"  => "rolfson.wellington",
                "email"     => "rolfson.wellington@example.org",
                "birthDate" => "1942-10-04 07:41:51"
            ],
            [
                "lastName"  => "Aufderhar",
                "firstName" => "Daphney",
                "username"  => "aufderhar.daphney",
                "email"     => "aufderhar.daphney@example.org",
                "birthDate" => "1972-07-24 09:57:46"
            ],
            [
                "lastName"  => "Kulas",
                "firstName" => "Wava",
                "username"  => "kulas.wava",
                "email"     => "kulas.wava@example.net",
                "birthDate" => "1948-08-21 03:50:44"
            ],
            [
                "lastName"  => "Boyer",
                "firstName" => "Leland",
                "username"  => "boyer.leland",
                "email"     => "boyer.leland@example.net",
                "birthDate" => "2008-12-05 11:10:11"
            ],
            [
                "lastName"  => "Wiegand",
                "firstName" => "Javier",
                "username"  => "wiegand.javier",
                "email"     => "wiegand.javier@example.com",
                "birthDate" => "1929-03-28 07:13:46"
            ],
            [
                "lastName"  => "Glover",
                "firstName" => "Shanelle",
                "username"  => "glover.shanelle",
                "email"     => "glover.shanelle@example.com",
                "birthDate" => "1962-07-19 04:21:34"
            ],
            [
                "lastName"  => "Runte",
                "firstName" => "Albin",
                "username"  => "runte.albin",
                "email"     => "runte.albin@example.net",
                "birthDate" => "1992-10-12 07:24:06"
            ],
            [
                "lastName"  => "Rau",
                "firstName" => "Leta",
                "username"  => "rau.leta",
                "email"     => "rau.leta@example.com",
                "birthDate" => "1916-04-07 16:44:15"
            ],
            [
                "lastName"  => "Becker",
                "firstName" => "Florencio",
                "username"  => "becker.florencio",
                "email"     => "becker.florencio@example.org",
                "birthDate" => "1945-10-13 02:54:28"
            ],
            [
                "lastName"  => "Rogahn",
                "firstName" => "Velva",
                "username"  => "rogahn.velva",
                "email"     => "rogahn.velva@example.net",
                "birthDate" => "2012-03-29 20:45:28"
            ],
            [
                "lastName"  => "Kozey",
                "firstName" => "Lorena",
                "username"  => "kozey.lorena",
                "email"     => "kozey.lorena@example.com",
                "birthDate" => "1924-08-31 16:49:06"
            ],
            [
                "lastName"  => "Rolfson",
                "firstName" => "Madaline",
                "username"  => "rolfson.madaline",
                "email"     => "rolfson.madaline@example.net",
                "birthDate" => "1977-06-26 16:49:57"
            ],
            [
                "lastName"  => "Nikolaus",
                "firstName" => "Buck",
                "username"  => "nikolaus.buck",
                "email"     => "nikolaus.buck@example.com",
                "birthDate" => "1998-12-07 10:29:30"
            ],
            [
                "lastName"  => "Bernier",
                "firstName" => "Efren",
                "username"  => "bernier.efren",
                "email"     => "bernier.efren@example.com",
                "birthDate" => "2001-10-23 16:04:17"
            ],
            [
                "lastName"  => "Feest",
                "firstName" => "Elissa",
                "username"  => "feest.elissa",
                "email"     => "feest.elissa@example.com",
                "birthDate" => "1952-11-07 22:52:28"
            ],
            [
                "lastName"  => "Ledner",
                "firstName" => "Wilford",
                "username"  => "ledner.wilford",
                "email"     => "ledner.wilford@example.com",
                "birthDate" => "1967-10-07 07:45:14"
            ],
            [
                "lastName"  => "Bode",
                "firstName" => "Kaia",
                "username"  => "bode.kaia",
                "email"     => "bode.kaia@example.org",
                "birthDate" => "1994-11-24 04:09:19"
            ],
            [
                "lastName"  => "O'Connell",
                "firstName" => "Edythe",
                "username"  => "o'connell.edythe",
                "email"     => "o'connell.edythe@example.com",
                "birthDate" => "2013-05-29 06:17:02"
            ],
            [
                "lastName"  => "Nicolas",
                "firstName" => "Camila",
                "username"  => "nicolas.camila",
                "email"     => "nicolas.camila@example.net",
                "birthDate" => "1933-03-03 12:56:56"
            ],
            [
                "lastName"  => "Bahringer",
                "firstName" => "Tyra",
                "username"  => "bahringer.tyra",
                "email"     => "bahringer.tyra@example.org",
                "birthDate" => "1985-05-09 12:16:33"
            ],
            [
                "lastName"  => "Kulas",
                "firstName" => "Oran",
                "username"  => "kulas.oran",
                "email"     => "kulas.oran@example.com",
                "birthDate" => "2005-03-31 22:20:49"
            ],
            [
                "lastName"  => "Cartwright",
                "firstName" => "Wilmer",
                "username"  => "cartwright.wilmer",
                "email"     => "cartwright.wilmer@example.net",
                "birthDate" => "1987-07-23 05:34:32"
            ],
            [
                "lastName"  => "Hane",
                "firstName" => "Nyah",
                "username"  => "hane.nyah",
                "email"     => "hane.nyah@example.org",
                "birthDate" => "1950-01-22 18:47:17"
            ],
            [
                "lastName"  => "Toy",
                "firstName" => "Geo",
                "username"  => "toy.geo",
                "email"     => "toy.geo@example.net",
                "birthDate" => "1922-01-04 19:50:13"
            ],
            [
                "lastName"  => "Waters",
                "firstName" => "Jaydon",
                "username"  => "waters.jaydon",
                "email"     => "waters.jaydon@example.net",
                "birthDate" => "1931-02-05 03:08:52"
            ],
            [
                "lastName"  => "Homenick",
                "firstName" => "Jordane",
                "username"  => "homenick.jordane",
                "email"     => "homenick.jordane@example.org",
                "birthDate" => "1949-02-06 01:09:36"
            ],
            [
                "lastName"  => "Kemmer",
                "firstName" => "Verner",
                "username"  => "kemmer.verner",
                "email"     => "kemmer.verner@example.org",
                "birthDate" => "1971-04-03 02:29:15"
            ],
            [
                "lastName"  => "Hegmann",
                "firstName" => "Haylee",
                "username"  => "hegmann.haylee",
                "email"     => "hegmann.haylee@example.com",
                "birthDate" => "2013-09-01 14:55:02"
            ],
            [
                "lastName"  => "Rippin",
                "firstName" => "Aaron",
                "username"  => "rippin.aaron",
                "email"     => "rippin.aaron@example.net",
                "birthDate" => "1961-06-11 23:48:55"
            ],
            [
                "lastName"  => "Lowe",
                "firstName" => "Lydia",
                "username"  => "lowe.lydia",
                "email"     => "lowe.lydia@example.net",
                "birthDate" => "1939-06-25 17:38:14"
            ],
            [
                "lastName"  => "Connelly",
                "firstName" => "Danika",
                "username"  => "connelly.danika",
                "email"     => "connelly.danika@example.com",
                "birthDate" => "1921-08-28 17:12:08"
            ],
            [
                "lastName"  => "Feeney",
                "firstName" => "Ernesto",
                "username"  => "feeney.ernesto",
                "email"     => "feeney.ernesto@example.com",
                "birthDate" => "2004-09-24 20:18:25"
            ],
            [
                "lastName"  => "Connelly",
                "firstName" => "Arvel",
                "username"  => "connelly.arvel",
                "email"     => "connelly.arvel@example.net",
                "birthDate" => "1932-02-16 16:13:37"
            ],
            [
                "lastName"  => "McCullough",
                "firstName" => "Libbie",
                "username"  => "mccullough.libbie",
                "email"     => "mccullough.libbie@example.org",
                "birthDate" => "1955-12-22 17:12:43"
            ],
            [
                "lastName"  => "Thompson",
                "firstName" => "Velva",
                "username"  => "thompson.velva",
                "email"     => "thompson.velva@example.com",
                "birthDate" => "1967-06-05 17:09:25"
            ],
            [
                "lastName"  => "Mohr",
                "firstName" => "Delmer",
                "username"  => "mohr.delmer",
                "email"     => "mohr.delmer@example.com",
                "birthDate" => "1953-06-07 23:57:29"
            ],
            [
                "lastName"  => "Thiel",
                "firstName" => "Junius",
                "username"  => "thiel.junius",
                "email"     => "thiel.junius@example.net",
                "birthDate" => "1976-06-13 00:34:54"
            ],
            [
                "lastName"  => "Ledner",
                "firstName" => "Krystel",
                "username"  => "ledner.krystel",
                "email"     => "ledner.krystel@example.com",
                "birthDate" => "1974-06-22 13:44:32"
            ],
            [
                "lastName"  => "Schowalter",
                "firstName" => "Robyn",
                "username"  => "schowalter.robyn",
                "email"     => "schowalter.robyn@example.net",
                "birthDate" => "1926-02-20 04:27:19"
            ],
            [
                "lastName"  => "Hilll",
                "firstName" => "Frieda",
                "username"  => "hilll.frieda",
                "email"     => "hilll.frieda@example.net",
                "birthDate" => "1941-10-07 03:48:22"
            ],
            [
                "lastName"  => "Botsford",
                "firstName" => "Terrance",
                "username"  => "botsford.terrance",
                "email"     => "botsford.terrance@example.org",
                "birthDate" => "1928-07-15 11:00:22"
            ],
            [
                "lastName"  => "Macejkovic",
                "firstName" => "Osbaldo",
                "username"  => "macejkovic.osbaldo",
                "email"     => "macejkovic.osbaldo@example.net",
                "birthDate" => "1976-09-21 00:17:05"
            ],
            [
                "lastName"  => "Rippin",
                "firstName" => "Elza",
                "username"  => "rippin.elza",
                "email"     => "rippin.elza@example.net",
                "birthDate" => "1978-08-31 18:54:04"
            ],
            [
                "lastName"  => "Wyman",
                "firstName" => "Loy",
                "username"  => "wyman.loy",
                "email"     => "wyman.loy@example.net",
                "birthDate" => "1980-09-16 08:19:04"
            ],
            [
                "lastName"  => "Pouros",
                "firstName" => "Salma",
                "username"  => "pouros.salma",
                "email"     => "pouros.salma@example.com",
                "birthDate" => "1981-11-23 16:19:56"
            ],
            [
                "lastName"  => "Kilback",
                "firstName" => "Jessika",
                "username"  => "kilback.jessika",
                "email"     => "kilback.jessika@example.com",
                "birthDate" => "1958-10-10 01:25:17"
            ],
            [
                "lastName"  => "Prohaska",
                "firstName" => "Gregg",
                "username"  => "prohaska.gregg",
                "email"     => "prohaska.gregg@example.net",
                "birthDate" => "1958-08-28 11:37:30"
            ],
            [
                "lastName"  => "Considine",
                "firstName" => "Delilah",
                "username"  => "considine.delilah",
                "email"     => "considine.delilah@example.com",
                "birthDate" => "1948-11-10 14:58:12"
            ],
            [
                "lastName"  => "Bernier",
                "firstName" => "Lorenza",
                "username"  => "bernier.lorenza",
                "email"     => "bernier.lorenza@example.org",
                "birthDate" => "1968-05-09 02:27:30"
            ],
            [
                "lastName"  => "Hammes",
                "firstName" => "Zetta",
                "username"  => "hammes.zetta",
                "email"     => "hammes.zetta@example.net",
                "birthDate" => "1948-05-08 00:59:52"
            ],
            [
                "lastName"  => "Gibson",
                "firstName" => "Ulises",
                "username"  => "gibson.ulises",
                "email"     => "gibson.ulises@example.org",
                "birthDate" => "1988-07-04 13:36:25"
            ],
            [
                "lastName"  => "Carroll",
                "firstName" => "Myrna",
                "username"  => "carroll.myrna",
                "email"     => "carroll.myrna@example.net",
                "birthDate" => "1932-05-13 12:47:05"
            ],
            [
                "lastName"  => "Effertz",
                "firstName" => "Porter",
                "username"  => "effertz.porter",
                "email"     => "effertz.porter@example.org",
                "birthDate" => "2006-01-10 08:35:04"
            ],
            [
                "lastName"  => "Morissette",
                "firstName" => "Dahlia",
                "username"  => "morissette.dahlia",
                "email"     => "morissette.dahlia@example.org",
                "birthDate" => "2014-05-26 22:41:20"
            ],
            [
                "lastName"  => "Casper",
                "firstName" => "Emory",
                "username"  => "casper.emory",
                "email"     => "casper.emory@example.net",
                "birthDate" => "2012-03-08 12:15:14"
            ]
        ];
    }
}
