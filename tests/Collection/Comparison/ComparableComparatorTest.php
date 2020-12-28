<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Comparison;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Test\Resources\TestIntegerObject;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Comparison\ComparableComparator
 */
class ComparableComparatorTest extends UnitTestCase
{
    public function test_that_compare_returns_zero_when_comparison_is_equal()
    {
        $integer1 = new TestIntegerObject(12);
        $integer2 = new TestIntegerObject(12);

        $comparator = new ComparableComparator();

        static::assertSame(0, $comparator->compare($integer1, $integer2));
    }

    public function test_that_compare_returns_pos_one_when_first_item_is_greater()
    {
        $integer1 = new TestIntegerObject(14);
        $integer2 = new TestIntegerObject(12);

        $comparator = new ComparableComparator();

        static::assertSame(1, $comparator->compare($integer1, $integer2));
    }

    public function test_that_compare_returns_neg_one_when_first_item_is_less()
    {
        $integer1 = new TestIntegerObject(10);
        $integer2 = new TestIntegerObject(12);

        $comparator = new ComparableComparator();

        static::assertSame(-1, $comparator->compare($integer1, $integer2));
    }
}
