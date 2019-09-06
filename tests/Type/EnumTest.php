<?php declare(strict_types=1);

namespace Novuso\System\Test\Type;

use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\DomainException;
use Novuso\System\Test\Resources\TestInvalidStatus;
use Novuso\System\Test\Resources\TestStatus;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Type\Enum
 */
class EnumTest extends UnitTestCase
{
    public function test_that_get_members_returns_expected()
    {
        $expected = ['ON' => 'on', 'OFF' => 'off'];
        $this->assertSame($expected, TestStatus::getMembers());
    }

    public function test_that_const_magic_method_returns_instance()
    {
        $weekDay = TestWeekDay::SUNDAY();
        $this->assertInstanceOf(TestWeekDay::class, $weekDay);
    }

    public function test_that_from_string_returns_expected_instance()
    {
        $weekDay = TestWeekDay::fromString('TestWeekDay::THURSDAY');
        $this->assertSame('THURSDAY', $weekDay->name());
    }

    public function test_that_from_name_returns_instance_with_same_name()
    {
        $weekDay = TestWeekDay::fromName('MONDAY');
        $this->assertSame('MONDAY', $weekDay->name());
    }

    public function test_that_from_value_returns_instance_with_same_value()
    {
        $weekDay = TestWeekDay::fromValue(TestWeekDay::THURSDAY);
        $this->assertSame(TestWeekDay::THURSDAY, $weekDay->value());
    }

    public function test_that_from_ordinal_returns_instance_with_same_ordinal()
    {
        $weekDay = TestWeekDay::fromOrdinal(6);
        $this->assertSame(6, $weekDay->ordinal());
    }

    public function test_that_to_string_returns_expected_string()
    {
        $this->assertSame('TestWeekDay::WEDNESDAY', TestWeekDay::WEDNESDAY()->toString());
    }

    public function test_that_string_cast_returns_expected_string()
    {
        $this->assertSame('TestWeekDay::FRIDAY', (string) TestWeekDay::FRIDAY());
    }

    public function test_that_it_is_json_encodable()
    {
        $data = ['week_day' => TestWeekDay::FRIDAY()];
        $this->assertSame('{"week_day":5}', json_encode($data));
    }

    public function test_that_serialize_returns_expected_state()
    {
        // TODO: update these tests when php7.4 is released
        $state = TestWeekDay::FRIDAY()->__serialize();
        $this->assertSame(5, $state['value']);
    }

    public function test_that_unserialize_works_as_expected()
    {
        // TODO: update these tests when php7.4 is released
        $data = ['value' => TestWeekDay::FRIDAY];
        $weekDay = TestWeekDay::FRIDAY();
        $weekDay->__unserialize($data);
        $this->assertSame(5, $weekDay->value());
    }

    public function test_that_unserialize_throws_exception_from_bad_data()
    {
        // TODO: update these tests when php7.4 is released
        $this->expectException(DomainException::class);
        $data = ['value' => 'Friday'];
        $weekDay = TestWeekDay::FRIDAY();
        $weekDay->__unserialize($data);
    }

    public function test_that_equals_returns_true_for_same_instance()
    {
        $weekDay = TestWeekDay::FRIDAY();
        $this->assertTrue($weekDay->equals($weekDay));
    }

    public function test_that_equals_returns_true_for_same_value()
    {
        $weekDay1 = TestWeekDay::FRIDAY();
        $weekDay2 = TestWeekDay::FRIDAY();
        $this->assertTrue($weekDay1->equals($weekDay2));
    }

    public function test_that_equals_returns_false_for_different_value()
    {
        $weekDay1 = TestWeekDay::FRIDAY();
        $weekDay2 = TestWeekDay::SUNDAY();
        $this->assertFalse($weekDay1->equals($weekDay2));
    }

    public function test_that_equals_returns_false_for_invalid_type()
    {
        $weekDay = TestWeekDay::FRIDAY();
        $this->assertFalse($weekDay->equals(5));
    }

    public function test_that_compare_to_returns_zero_for_same_instance()
    {
        $weekDay = TestWeekDay::FRIDAY();
        $this->assertSame(0, $weekDay->compareTo($weekDay));
    }

    public function test_that_compare_to_returns_zero_for_same_value()
    {
        $weekDay1 = TestWeekDay::FRIDAY();
        $weekDay2 = TestWeekDay::FRIDAY();
        $this->assertSame(0, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_compare_to_returns_pos_one_for_greater_value()
    {
        $weekDay1 = TestWeekDay::FRIDAY();
        $weekDay2 = TestWeekDay::SUNDAY();
        $this->assertSame(1, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_compare_to_returns_neg_one_for_lesser_value()
    {
        $weekDay1 = TestWeekDay::SUNDAY();
        $weekDay2 = TestWeekDay::FRIDAY();
        $this->assertSame(-1, $weekDay1->compareTo($weekDay2));
    }

    public function test_that_hash_value_returns_expected_string()
    {
        $this->assertSame('SUNDAY', TestWeekDay::SUNDAY()->hashValue());
    }

    public function test_that_duplicate_constant_values_throws_exception()
    {
        $this->expectException(DomainException::class);
        TestInvalidStatus::CREATED();
    }

    public function test_that_magic_method_throws_exception_for_invalid_name()
    {
        $this->expectException(DomainException::class);
        TestWeekDay::FOO();
    }

    public function test_that_from_value_throws_exception_for_invalid_value()
    {
        $this->expectException(DomainException::class);
        TestWeekDay::fromValue(10);
    }

    public function test_that_from_ordinal_throws_exception_for_invalid_ordinal()
    {
        $this->expectException(DomainException::class);
        TestWeekDay::fromOrdinal(10);
    }

    public function test_that_compare_to_throws_exception_for_invalid_argument()
    {
        $this->expectException(AssertionException::class);
        $weekDay1 = TestWeekDay::FRIDAY();
        $weekDay2 = TestWeekDay::SUNDAY;
        $weekDay1->compareTo($weekDay2);
    }
}
