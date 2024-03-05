<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Comparison;

use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FloatComparator::class)]
class FloatComparatorTest extends UnitTestCase
{
    public function test_that_compare_returns_zero_when_comparison_is_equal()
    {
        $float1 = 12.0;
        $float2 = 12.0;

        $comparator = new FloatComparator();

        static::assertSame(0, $comparator->compare($float1, $float2));
    }

    public function test_that_compare_returns_pos_one_when_first_item_is_greater()
    {
        $float1 = 12.1;
        $float2 = 12.0;

        $comparator = new FloatComparator();

        static::assertSame(1, $comparator->compare($float1, $float2));
    }

    public function test_that_compare_returns_neg_one_when_first_item_is_less()
    {
        $float1 = 12.0;
        $float2 = 12.1;

        $comparator = new FloatComparator();

        static::assertSame(-1, $comparator->compare($float1, $float2));
    }
}
