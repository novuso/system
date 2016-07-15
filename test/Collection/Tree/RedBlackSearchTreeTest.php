<?php

namespace Novuso\Test\System\Collection\Tree;

use Novuso\System\Collection\Compare\ComparableComparator;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\Test\System\Resources\WeekDay;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Collection\Tree\RedBlackSearchTree
 */
class RedBlackSearchTreeTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $this->assertTrue($tree->isEmpty());
    }

    public function test_that_adding_items_affects_count()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertCount(7, $tree);
    }

    public function test_that_duplicate_keys_are_overridden()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->set(WeekDay::TUESDAY(), 'Tacos');
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertEquals('Tuesday', $tree->get(WeekDay::TUESDAY()));
    }

    public function test_that_has_returns_true_for_valid_key()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue($tree->has(WeekDay::SATURDAY()));
    }

    public function test_that_remove_correctly_finds_and_removes()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->remove($key);
        }
        $this->assertTrue($tree->isEmpty());
        // should have no effect
        $tree->remove(WeekDay::SATURDAY());
    }

    public function test_that_keys_returns_empty_traversable_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $keys = $tree->keys();
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(0, $count);
    }

    public function test_that_keys_returns_traversable_keys_in_order()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $count = 0;
        /** @var WeekDay $key */
        foreach ($tree->keys() as $key) {
            if ($key->value() !== $count) {
                throw new \Exception('Keys out of order');
            }
            $count++;
        }
        $this->assertSame(7, $count);
    }

    public function test_that_range_keys_returns_inclusive_set()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $keys = $tree->rangeKeys(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $count = 0;
        foreach ($keys as $key) {
            $count++;
        }
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_includes_key_arguments_when_present()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $count = $tree->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_key_arguments_when_missing()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(WeekDay::THURSDAY());
        $count = $tree->rangeCount(WeekDay::TUESDAY(), WeekDay::THURSDAY());
        $this->assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $count = $tree->rangeCount(WeekDay::THURSDAY(), WeekDay::TUESDAY());
        $this->assertSame(0, $count);
    }

    public function test_that_remove_min_correctly_finds_and_removes()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $tree->removeMin();
        }
        $this->assertSame('Saturday', $tree->get(WeekDay::SATURDAY()));
    }

    public function test_that_remove_max_correctly_finds_and_removes()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        for ($i = 0; $i < 6; $i++) {
            $tree->removeMax();
        }
        $this->assertSame('Sunday', $tree->get(WeekDay::SUNDAY()));
    }

    public function test_that_floor_returns_equal_key_when_present()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(WeekDay::FRIDAY()->equals($tree->floor(WeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_key_equal_or_less_than_arg()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(WeekDay::THURSDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($tree->floor(WeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_key_not_found()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(WeekDay::SUNDAY());
        $this->assertNull($tree->floor(WeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_key_when_present()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(WeekDay::MONDAY()->equals($tree->ceiling(WeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_key_equal_or_greater_than_arg()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(WeekDay::TUESDAY());
        $this->assertTrue(WeekDay::WEDNESDAY()->equals($tree->ceiling(WeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_key_not_found()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(WeekDay::SATURDAY());
        $this->assertNull($tree->ceiling(WeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_key()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertSame(4, $tree->rank(WeekDay::THURSDAY()));
    }

    public function test_that_select_returns_key_assoc_with_index()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(WeekDay::THURSDAY()->equals($tree->select(4)));
    }

    public function test_that_clone_includes_linked_nodes()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $copy = clone $tree;
        while (!$tree->isEmpty()) {
            $tree->removeMin();
        }
        $this->assertCount(7, $copy);
    }

    /**
     * @expectedException \Novuso\System\Exception\KeyException
     */
    public function test_that_get_throws_exception_for_undefined_key()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->get(WeekDay::SUNDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_min_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->min();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_max_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->max();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_min_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->removeMin();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_remove_max_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->removeMax();
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_floor_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->floor(WeekDay::WEDNESDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\UnderflowException
     */
    public function test_that_ceiling_throws_exception_when_empty()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->ceiling(WeekDay::WEDNESDAY());
    }

    /**
     * @expectedException \Novuso\System\Exception\LookupException
     */
    public function test_that_select_throws_exception_when_rank_out_of_bounds()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->select(10);
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
