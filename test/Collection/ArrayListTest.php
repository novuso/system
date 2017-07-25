<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\ArrayList;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\ArrayList
 * @covers \Novuso\System\Collection\Traits\ItemTypeMethods
 */
class ArrayListTest extends UnitTestCase
{
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
        $list->sort(function ($a, $b) {
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

    public function test_that_first_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('foo', $list->first());
    }

    public function test_that_last_returns_expected_item()
    {
        $list = ArrayList::of('string');
        $list[] = 'foo';
        $list[] = 'bar';
        $list[] = 'baz';
        $this->assertSame('baz', $list->last());
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

    /**
     * @expectedException \AssertionError
     */
    public function test_that_add_triggers_assert_error_for_invalid_item_type()
    {
        ArrayList::of('object')->add('string');
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_set_triggers_assert_error_for_invalid_item_type()
    {
        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->set(0, 'string');
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_offset_set_triggers_assert_error_for_invalid_index_type()
    {
        $list = ArrayList::of('string');
        $list['foo'] = 'bar';
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_offset_get_triggers_assert_error_for_invalid_index_type()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        $list['foo'];
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_offset_exists_triggers_assert_error_for_invalid_index_type()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        isset($list['foo']);
    }

    /**
     * @expectedException \AssertionError
     */
    public function test_that_offset_unset_triggers_assert_error_for_invalid_index_type()
    {
        $list = ArrayList::of('string');
        $list->add('foo');
        unset($list['foo']);
    }

    /**
     * @expectedException \Novuso\System\Exception\IndexException
     */
    public function test_that_set_throws_exception_for_invalid_index()
    {
        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->set(1, new \stdClass());
    }

    /**
     * @expectedException \Novuso\System\Exception\IndexException
     */
    public function test_that_get_throws_exception_for_invalid_index()
    {
        $list = ArrayList::of('object');
        $list->add(new \stdClass());
        $list->get(1);
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_first_throws_exception_when_empty()
    {
        $list = ArrayList::of('string');
        $list->first();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_last_throws_exception_when_empty()
    {
        $list = ArrayList::of('string');
        $list->last();
    }
}
