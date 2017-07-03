<?php

namespace Novuso\Test\System\Collection\Sort;

use Novuso\System\Collection\Compare\ComparableComparator;
use Novuso\System\Collection\Compare\FloatComparator;
use Novuso\System\Collection\Compare\IntegerComparator;
use Novuso\System\Collection\Compare\StringComparator;
use Novuso\System\Collection\Sort\Merge;
use Novuso\Test\System\Resources\User;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Sort\Merge
 * @covers \Novuso\System\Collection\Compare\ComparableComparator
 * @covers \Novuso\System\Collection\Compare\FloatComparator
 * @covers \Novuso\System\Collection\Compare\IntegerComparator
 * @covers \Novuso\System\Collection\Compare\StringComparator
 */
class MergeTest extends UnitTestCase
{
    use SortDataProvider;

    /**
     * @dataProvider comparableArrayProvider
     */
    public function test_sort_correctly_sorts_comparable_array($data, $sorted)
    {
        $comparator = [new ComparableComparator(), 'compare'];
        Merge::sort($data, $comparator);
        $output = [];
        foreach ($data as $user) {
            $output[] = $user->toArray();
        }
        $this->assertSame($sorted, $output);
    }

    /**
     * @dataProvider stringArrayProvider
     */
    public function test_sort_correctly_sorts_string_array($data, $sorted)
    {
        $comparator = [new StringComparator(), 'compare'];
        Merge::sort($data, $comparator);
        $this->assertSame($sorted, $data);
    }

    /**
     * @dataProvider floatArrayProvider
     */
    public function test_sort_correctly_sorts_float_array($data, $sorted)
    {
        $comparator = [new FloatComparator(), 'compare'];
        Merge::sort($data, $comparator);
        $this->assertSame($sorted, $data);
    }

    /**
     * @dataProvider integerArrayProvider
     */
    public function test_sort_correctly_sorts_integer_array($data, $sorted)
    {
        $comparator = [new IntegerComparator(), 'compare'];
        Merge::sort($data, $comparator);
        $this->assertSame($sorted, $data);
    }

    public function test_sort_correctly_sorts_custom_order()
    {
        $records = $this->getUserDataUnsorted();
        $data = [];
        foreach ($records as $record) {
            $data[] = new User($record);
        }
        Merge::sort($data, function ($user1, $user2) {
            $comp = strnatcmp($user1->lastName(), $user2->lastName());
            if ($comp > 0) {
                return 1;
            }
            if ($comp < 0) {
                return -1;
            }

            return 0;
        });
        $sorted = $this->getUserDataSortedByLastName();
        $valid = true;
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            $user = $data[$i];
            if ($user->lastName() !== $sorted[$i]['lastName']) {
                $valid = false;
            }
        }
        $this->assertTrue($valid);
    }

    public function test_sort_keeps_order_of_already_sorted_array()
    {
        $records = $this->getUserDataSortedByLastName();
        $data = [];
        foreach ($records as $record) {
            $data[] = new User($record);
        }
        Merge::sort($data, function ($user1, $user2) {
            $comp = strnatcmp($user1->lastName(), $user2->lastName());
            if ($comp > 0) {
                return 1;
            }
            if ($comp < 0) {
                return -1;
            }

            return 0;
        });
        $sorted = $this->getUserDataSortedByLastName();
        $valid = true;
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            $user = $data[$i];
            if ($user->lastName() !== $sorted[$i]['lastName']) {
                $valid = false;
            }
        }
        $this->assertTrue($valid);
    }
}
