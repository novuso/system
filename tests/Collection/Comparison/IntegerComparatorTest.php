<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Comparison;

use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Comparison\IntegerComparator
 */
class IntegerComparatorTest extends UnitTestCase
{
    public function test_that_compare_returns_zero_when_comparison_is_equal()
    {
        $integer1 = 12;
        $integer2 = 12;

        $comparator = new IntegerComparator();

        static::assertSame(0, $comparator->compare($integer1, $integer2));
    }

    public function test_that_compare_returns_pos_one_when_first_item_is_greater()
    {
        $integer1 = 14;
        $integer2 = 12;

        $comparator = new IntegerComparator();

        static::assertSame(1, $comparator->compare($integer1, $integer2));
    }

    public function test_that_compare_returns_neg_one_when_first_item_is_less()
    {
        $integer1 = 10;
        $integer2 = 12;

        $comparator = new IntegerComparator();

        static::assertSame(-1, $comparator->compare($integer1, $integer2));
    }
}
