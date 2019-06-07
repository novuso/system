<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Tree;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Exception\KeyException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Tree\RedBlackSearchTree
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
        $tree->set(TestWeekDay::TUESDAY(), 'Tacos');
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertEquals('Tuesday', $tree->get(TestWeekDay::TUESDAY()));
    }

    public function test_that_has_returns_true_for_valid_key()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue($tree->has(TestWeekDay::SATURDAY()));
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
        $tree->remove(TestWeekDay::SATURDAY());
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
        /** @var TestWeekDay $key */
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
        $keys = $tree->rangeKeys(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
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
        $count = $tree->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $this->assertSame(3, $count);
    }

    public function test_that_range_count_does_not_include_key_arguments_when_missing()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(TestWeekDay::THURSDAY());
        $count = $tree->rangeCount(TestWeekDay::TUESDAY(), TestWeekDay::THURSDAY());
        $this->assertSame(2, $count);
    }

    public function test_that_range_count_returns_zero_for_args_out_of_order()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $count = $tree->rangeCount(TestWeekDay::THURSDAY(), TestWeekDay::TUESDAY());
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
        $this->assertSame('Saturday', $tree->get(TestWeekDay::SATURDAY()));
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
        $this->assertSame('Sunday', $tree->get(TestWeekDay::SUNDAY()));
    }

    public function test_that_floor_returns_equal_key_when_present()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::FRIDAY()->equals($tree->floor(TestWeekDay::FRIDAY())));
    }

    public function test_that_floor_returns_largest_key_equal_or_less_than_arg()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(TestWeekDay::THURSDAY());
        $this->assertTrue(TestWeekDay::WEDNESDAY()->equals($tree->floor(TestWeekDay::THURSDAY())));
    }

    public function test_that_floor_returns_null_when_equal_or_less_key_not_found()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(TestWeekDay::SUNDAY());
        $this->assertNull($tree->floor(TestWeekDay::SUNDAY()));
    }

    public function test_that_ceiling_returns_equal_key_when_present()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::MONDAY()->equals($tree->ceiling(TestWeekDay::MONDAY())));
    }

    public function test_that_ceiling_returns_smallest_key_equal_or_greater_than_arg()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(TestWeekDay::TUESDAY());
        $this->assertTrue(TestWeekDay::WEDNESDAY()->equals($tree->ceiling(TestWeekDay::TUESDAY())));
    }

    public function test_that_ceiling_returns_null_when_equal_or_greater_key_not_found()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $tree->remove(TestWeekDay::SATURDAY());
        $this->assertNull($tree->ceiling(TestWeekDay::SATURDAY()));
    }

    public function test_that_rank_returns_expected_value_for_key()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertSame(4, $tree->rank(TestWeekDay::THURSDAY()));
    }

    public function test_that_select_returns_key_assoc_with_index()
    {
        $tree = new RedBlackSearchTree(new ComparableComparator());
        foreach ($this->getWeekDays() as $value => $key) {
            $tree->set($key, $value);
        }
        $this->assertTrue(TestWeekDay::THURSDAY()->equals($tree->select(4)));
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

    public function test_that_get_throws_exception_for_undefined_key()
    {
        $this->expectException(KeyException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->get(TestWeekDay::SUNDAY());
    }

    public function test_that_min_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->min();
    }

    public function test_that_max_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->max();
    }

    public function test_that_remove_min_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->removeMin();
    }

    public function test_that_remove_max_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->removeMax();
    }

    public function test_that_floor_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->floor(TestWeekDay::WEDNESDAY());
    }

    public function test_that_ceiling_throws_exception_when_empty()
    {
        $this->expectException(UnderflowException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->ceiling(TestWeekDay::WEDNESDAY());
    }

    public function test_that_select_throws_exception_when_rank_out_of_bounds()
    {
        $this->expectException(LookupException::class);
        $tree = new RedBlackSearchTree(new ComparableComparator());
        $tree->select(10);
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
