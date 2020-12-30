<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Comparison;

use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Comparison\StringComparator
 */
class StringComparatorTest extends UnitTestCase
{
    public function test_that_compare_returns_zero_when_comparison_is_equal()
    {
        $string1 = 'item10';
        $string2 = 'item10';

        $comparator = new StringComparator();

        static::assertSame(0, $comparator->compare($string1, $string2));
    }

    public function test_that_compare_returns_pos_one_when_first_item_is_greater()
    {
        $string1 = 'item10';
        $string2 = 'item2';

        $comparator = new StringComparator();

        static::assertSame(1, $comparator->compare($string1, $string2));
    }

    public function test_that_compare_returns_neg_one_when_first_item_is_less()
    {
        $string1 = 'item2';
        $string2 = 'item10';

        $comparator = new StringComparator();

        static::assertSame(-1, $comparator->compare($string1, $string2));
    }
}
