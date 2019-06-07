<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\Collection\Sort\SortDataProvider;
use Novuso\System\Test\Resources\TestUser;
use Novuso\System\Test\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\ArrayList
 * @covers \Novuso\System\Collection\Mixin\ItemTypeMethods
 */
class ArrayListTest extends UnitTestCase
{
    use SortDataProvider;

    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(ArrayList::of('string')->isEmpty());
    }

    public function test_that_added_items_affect_count()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('foo');
        $this->assertSame(3, count($list));
    }

    public function test_that_added_items_affect_length()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('foo');
        $this->assertSame(3, $list->length());
    }

    public function test_that_replace_returns_expected_instance()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertSame(['one', 'two', 'three'], $list->replace(['one', 'two', 'three'])->toArray());
    }

    public function test_that_set_replaces_item_at_an_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->set(1, 'baz');
        $this->assertSame(2, count($list));
    }

    public function test_that_set_replaces_item_at_a_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->set(-1, 'baz');
        $this->assertSame('baz', $list->get(1));
    }

    public function test_that_get_returns_item_at_pos_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertSame('bar', $list->get(1));
    }

    public function test_that_get_returns_item_at_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertSame('bar', $list->get(-2));
    }

    public function test_that_has_returns_true_for_index_in_bounds()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertTrue($list->has(2));
    }

    public function test_that_has_returns_false_for_index_out_of_bounds()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertFalse($list->has(4));
    }

    public function test_that_remove_deletes_item_and_reindexes_list()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(1);
        $this->assertSame('baz', $list->get(1));
    }

    public function test_that_remove_deletes_correct_item_at_neg_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(-2);
        $this->assertSame('baz', $list->get(1));
    }

    public function test_that_remove_fails_silently_at_out_of_bounds_index()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $list->remove(4);
        $this->assertSame(3, count($list));
    }

    public function test_that_contains_returns_true_when_item_is_present_strong_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->contains(2));
    }

    public function test_that_contains_returns_false_when_item_is_not_present_strong_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertFalse($list->contains(5));
    }

    public function test_that_contains_returns_false_when_item_is_present_different_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertFalse($list->contains('2'));
    }

    public function test_that_contains_returns_true_when_item_is_present_weak_type()
    {
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->contains('2', $strict = false));
    }

    public function test_that_offset_set_adds_item_when_used_without_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $this->assertSame('bar', $list[1]);
    }

    public function test_that_offset_set_replaces_item_at_given_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[1] = 'baz';
        $this->assertSame(2, count($list));
    }

    public function test_that_offset_exists_returns_true_for_index_in_bounds()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $this->assertTrue(isset($list[1]));
    }

    public function test_that_offset_exists_returns_false_for_index_out_of_bounds()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $this->assertFalse(isset($list[2]));
    }

    public function test_that_offset_unset_deletes_item_and_reindexes_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        unset($list[1]);
        $this->assertSame('baz', $list[1]);
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
        $this->assertSame($reverse, $list->toArray());
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
        }, $stable = true);
        $sorted = $this->getUserDataSortedByLastName();
        $valid = true;
        $count = count($list);
        for ($i = 0; $i < $count; $i++) {
            $user = $list[$i];
            if ($user->lastName() !== $sorted[$i]['lastName']) {
                $valid = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_that_reverse_returns_expected_instance()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list->add('bar');
        $list->add('baz');
        $this->assertSame(['baz', 'bar', 'foo'], $list->reverse()->toArray());
    }

    public function test_that_head_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('foo', $list->head());
    }

    public function test_that_tail_returns_expected_list()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame(['bar', 'baz'], $list->tail()->toArray());
    }

    public function test_that_first_returns_default_when_empty()
    {
        $this->assertSame('default', ArrayList::of('string')->first(function (string $item) {
            return strpos($item, '@') !== false;
        }, 'default'));
    }

    public function test_that_first_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('foo', $list->first());
    }

    public function test_that_first_returns_expected_item_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('bar', $list->first(function (string $item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_last_returns_default_when_empty()
    {
        $this->assertSame('default', ArrayList::of('string')->last(function (string $item) {
            return strpos($item, '@') !== false;
        }, 'default'));
    }

    public function test_that_last_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('baz', $list->last());
    }

    public function test_that_last_returns_expected_item_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('baz', $list->last(function (string $item) {
            return substr($item, 0, 1) === 'b';
        }));
    }

    public function test_that_index_of_returns_expected_index()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame(1, $list->indexOf('bar'));
    }

    public function test_that_index_of_returns_null_when_item_not_found()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertNull($list->indexOf('buz'));
    }

    public function test_that_index_of_returns_expected_index_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame(1, $list->indexOf(function (string $item) {
            return $item === 'bar';
        }));
    }

    public function test_that_index_of_returns_null_when_item_not_found_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertNull($list->indexOf(function (string $item) {
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
        $this->assertSame(3, $list->lastIndexOf('bar'));
    }

    public function test_that_last_index_of_returns_null_when_item_not_found()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertNull($list->lastIndexOf('buz'));
    }

    public function test_that_last_index_of_returns_expected_index_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $list[] = 'bar';
        $this->assertSame(3, $list->lastIndexOf(function (string $item) {
            return $item === 'bar';
        }));
    }

    public function test_that_last_index_of_returns_null_when_item_not_found_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertNull($list->lastIndexOf(function (string $item) {
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
                $this->assertSame('bar', $list->current());
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
                $this->assertSame('bar', $list->current());
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
                $this->assertSame('bar', $item);
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
        $this->assertSame(['bar', 'foo', 'baz'], $list->unique()->toArray());
    }

    public function test_that_unique_returns_expected_list_with_callback()
    {
        $list = ArrayList::of('string');
        $list[] = 'bar';
        $list[] = 'foo';
        $list[] = 'baz';
        $list[] = 'bar';
        $list[] = 'foo';
        $this->assertSame(['bar', 'foo'], $list->unique(function (string $item) {
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
        $this->assertSame(['bar', 'baz', 'foo'], $list->slice(1, 3)->toArray());
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
        $this->assertSame(['foo', 'bar', 'baz'], $list->page(2, 3)->toArray());
    }

    public function test_that_max_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 5356;
        $list[] = 7489;
        $list[] = 8936;
        $this->assertSame(8936, $list->max());
    }

    public function test_that_max_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];
        $this->assertSame(['age' => 32], $list->max(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_min_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 5356;
        $list[] = 7489;
        $list[] = 8936;
        $this->assertSame(5356, $list->min());
    }

    public function test_that_min_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];
        $this->assertSame(['age' => 19], $list->min(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_sum_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 1;
        $list[] = 2;
        $list[] = 3;
        $this->assertSame(6, $list->sum());
    }

    public function test_that_sum_returns_null_with_empty_list()
    {
        $this->assertNull(ArrayList::of('int')->sum());
    }

    public function test_that_sum_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 19];
        $list[] = ['age' => 32];
        $list[] = ['age' => 26];
        $this->assertSame(77, $list->sum(function (array $data) {
            return $data['age'];
        }));
    }

    public function test_that_average_returns_expected_value()
    {
        $list = ArrayList::of('int');
        $list[] = 1;
        $list[] = 2;
        $list[] = 3;
        $this->assertEquals(2.0, $list->average());
    }

    public function test_that_average_returns_null_with_empty_list()
    {
        $this->assertNull(ArrayList::of('int')->average());
    }

    public function test_that_average_returns_expected_value_with_callback()
    {
        $list = ArrayList::of('array');
        $list[] = ['age' => 18];
        $list[] = ['age' => 31];
        $list[] = ['age' => 26];
        $this->assertEquals(25.0, $list->average(function (array $data) {
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
        $this->assertSame($items, $copy->toArray());
    }

    public function test_that_calling_key_without_valid_item_returns_null()
    {
        $list = ArrayList::of('string');
        $this->assertNull($list->key());
    }

    public function test_that_calling_current_without_valid_item_returns_null()
    {
        $list = ArrayList::of('string');
        $this->assertNull($list->current());
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
        $this->assertSame(['foo', 'bar', 'baz'], $output->toArray());
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
        $this->assertSame([3, 3, 3], $output->toArray());
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
        $this->assertSame('bar', $item);
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
        $this->assertNull($item);
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
        $this->assertSame(['bar', 'baz'], $output->toArray());
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
        $this->assertSame(['foo'], $output->toArray());
    }

    public function test_that_any_returns_true_when_an_item_passes_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertTrue($list->any(function ($item) {
            return $item === 'foo';
        }));
    }

    public function test_that_any_returns_false_when_no_item_passes_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertFalse($list->any(function ($item) {
            return $item === 'buz';
        }));
    }

    public function test_that_every_returns_true_when_all_items_pass_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertTrue($list->every(function ($item) {
            return strlen($item) === 3;
        }));
    }

    public function test_that_every_returns_false_when_an_item_fails_test()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertFalse($list->every(function ($item) {
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
        $this->assertTrue($parts[0]->toArray() === ['bar', 'baz'] && $parts[1]->toArray() === ['foo']);
    }

    public function test_that_to_json_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('["foo","bar","baz"]', $list->toJson());
    }

    public function test_that_it_is_json_encodable()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('["foo","bar","baz"]', json_encode($list));
    }

    public function test_that_to_string_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('["foo","bar","baz"]', $list->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('["foo","bar","baz"]', (string) $list);
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
}
