<?php

namespace Novuso\Test\System\Type;

use Novuso\Test\System\Resources\InvalidStatus;
use Novuso\Test\System\Resources\Status;
use Novuso\Test\System\Resources\WeekDay;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Type\Enum
 */
class EnumTest extends UnitTestCase
{
    public function test_that_get_members_returns_expected()
    {
        $expected = ['ON' => 'on', 'OFF' => 'off'];
        $this->assertSame($expected, Status::getMembers());
    }

    public function test_that_const_magic_method_returns_instance()
    {
        $weekDay = WeekDay::SUNDAY();
        $this->assertInstanceOf(WeekDay::class, $weekDay);
    }

    public function test_that_from_name_returns_instance_with_same_name()
    {
        $weekDay = WeekDay::fromName('MONDAY');
        $this->assertSame('MONDAY', $weekDay->name());
    }

    public function test_that_from_value_returns_instance_with_same_value()
    {
        $weekDay = WeekDay::fromValue(WeekDay::THURSDAY);
        $this->assertSame(WeekDay::THURSDAY, $weekDay->value());
    }

    public function test_that_from_ordinal_returns_instance_with_same_ordinal()
    {
        $weekDay = WeekDay::fromOrdinal(6);
        $this->assertSame(6, $weekDay->ordinal());
    }

    public function test_that_to_string_returns_expected_string()
    {
        $this->assertSame('WeekDay.WEDNESDAY', WeekDay::WEDNESDAY()->toString());
    }

    public function test_that_string_cast_returns_expected_string()
    {
        $this->assertSame('WeekDay.FRIDAY', (string) WeekDay::FRIDAY());
    }

    public function test_that_it_is_json_encodable()
    {
        $data = ['week_day' => WeekDay::FRIDAY()];
        $this->assertSame('{"week_day":5}', json_encode($data));
    }

    public function test_that_it_is_serializable()
    {
        $state = serialize(WeekDay::FRIDAY());
        $weekDay = unserialize($state);
        $this->assertSame('WeekDay.FRIDAY', (string) $weekDay);
    }

    public function test_that_equals_returns_true_for_same_instance()
    {
        $weekDay = WeekDay::FRIDAY();
        $this->assertTrue($weekDay->equals($weekDay));
    }

    public function test_that_equals_returns_true_for_same_value()
    {
        $weekDay1 = WeekDay::FRIDAY();
        $weekDay2 = WeekDay::FRIDAY();
        $this->assertTrue($weekDay1->equals($weekDay2));
    }

    public function test_that_equals_returns_false_for_different_value()
    {
        $weekDay1 = WeekDay::FRIDAY();
        $weekDay2 = WeekDay::SUNDAY();
        $this->assertFalse($weekDay1->equals($weekDay2));
    }

    public function test_that_equals_returns_false_for_invalid_type()
    {
        $weekDay = WeekDay::FRIDAY();
        $this->assertFalse($weekDay->equals(5));
    }

    public function test_that_compare_to_returns_zero_for_same_instance()
    {
        $weekDay = WeekDay::FRIDAY();
        $this->assertSame(0, $weekDay->compareTo($weekDay));
    }

    public function test_that_compare_to_returns_zero_for_same_value()
    {
        $weekDay1 = WeekDay::FRIDAY();
        $weekDay2 = WeekDay::FRIDAY();
        $this->assertSame(0, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_compare_to_returns_pos_one_for_greater_value()
    {
        $weekDay1 = WeekDay::FRIDAY();
        $weekDay2 = WeekDay::SUNDAY();
        $this->assertSame(1, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_compare_to_returns_neg_one_for_lesser_value()
    {
        $weekDay1 = WeekDay::SUNDAY();
        $weekDay2 = WeekDay::FRIDAY();
        $this->assertSame(-1, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_hash_value_returns_expected_string()
    {
        $this->assertSame('SUNDAY', WeekDay::SUNDAY()->hashValue());
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_duplicate_constant_values_throws_exception()
    {
        InvalidStatus::CREATED();
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_magic_method_throws_exception_for_invalid_name()
    {
        WeekDay::FOO();
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_from_value_throws_exception_for_invalid_value()
    {
        WeekDay::fromValue(10);
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_from_ordinal_throws_exception_for_invalid_ordinal()
    {
        WeekDay::fromOrdinal(10);
    }

    /**
     * @expectedException AssertionError
     */
    public function test_that_compare_to_throws_exception_for_invalid_argument()
    {
        $weekDay1 = WeekDay::FRIDAY();
        $weekDay2 = WeekDay::SUNDAY;
        $weekDay1->compareTo($weekDay2);
    }
}
