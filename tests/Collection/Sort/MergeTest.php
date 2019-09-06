<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Sort;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Collection\Comparison\FunctionComparator;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Collection\Sort\Merge;
use Novuso\System\Test\Resources\TestUser;
use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Type\Comparable;

/**
 * @covers \Novuso\System\Collection\Sort\Merge
 * @covers \Novuso\System\Collection\Comparison\ComparableComparator
 * @covers \Novuso\System\Collection\Comparison\FloatComparator
 * @covers \Novuso\System\Collection\Comparison\IntegerComparator
 * @covers \Novuso\System\Collection\Comparison\StringComparator
 * @covers \Novuso\System\Collection\Comparison\FunctionComparator
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
     * @dataProvider comparableArrayProvider
     */
    public function test_sort_correctly_sorts_callback_array($data, $sorted)
    {
        $comparator = [new FunctionComparator(function (Comparable $item1, Comparable $item2) {
            return $item1->compareTo($item2);
        }), 'compare'];
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
            $data[] = new TestUser($record);
        }
        Merge::sort($data, function (TestUser $user1, TestUser $user2) {
            $comp = strnatcmp($user1->lastName(), $user2->lastName());

            return $comp <=> 0;
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
            $data[] = new TestUser($record);
        }
        Merge::sort($data, function (TestUser $user1, TestUser $user2) {
            $comp = strnatcmp($user1->lastName(), $user2->lastName());

            return $comp <=> 0;
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
