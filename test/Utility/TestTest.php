<?php

namespace Novuso\Test\System\Utility;

use Novuso\System\Utility\Test;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Utility\Test
 */
class TestTest extends UnitTestCase
{
    use TestDataProvider;

    /**
     * @dataProvider validScalarProvider
     */
    public function test_that_is_scalar_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isScalar($value));
    }

    /**
     * @dataProvider invalidScalarProvider
     */
    public function test_that_is_scalar_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isScalar($value));
    }

    /**
     * @dataProvider validBoolProvider
     */
    public function test_that_is_bool_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isBool($value));
    }

    /**
     * @dataProvider invalidBoolProvider
     */
    public function test_that_is_bool_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isBool($value));
    }

    /**
     * @dataProvider validFloatProvider
     */
    public function test_that_is_float_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isFloat($value));
    }

    /**
     * @dataProvider invalidFloatProvider
     */
    public function test_that_is_float_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isFloat($value));
    }

    /**
     * @dataProvider validIntProvider
     */
    public function test_that_is_int_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isInt($value));
    }

    /**
     * @dataProvider invalidIntProvider
     */
    public function test_that_is_int_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isInt($value));
    }

    /**
     * @dataProvider validStringProvider
     */
    public function test_that_is_string_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isString($value));
    }

    /**
     * @dataProvider invalidStringProvider
     */
    public function test_that_is_string_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isString($value));
    }

    /**
     * @dataProvider validArrayProvider
     */
    public function test_that_is_array_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isArray($value));
    }

    /**
     * @dataProvider invalidArrayProvider
     */
    public function test_that_is_array_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isArray($value));
    }

    /**
     * @dataProvider validObjectProvider
     */
    public function test_that_is_object_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isObject($value));
    }

    /**
     * @dataProvider invalidObjectProvider
     */
    public function test_that_is_object_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isObject($value));
    }

    /**
     * @dataProvider validCallableProvider
     */
    public function test_that_is_callable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isCallable($value));
    }

    /**
     * @dataProvider invalidCallableProvider
     */
    public function test_that_is_callable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isCallable($value));
    }

    /**
     * @dataProvider validNullProvider
     */
    public function test_that_is_null_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isNull($value));
    }

    /**
     * @dataProvider invalidNullProvider
     */
    public function test_that_is_null_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isNull($value));
    }

    /**
     * @dataProvider validNotNullProvider
     */
    public function test_that_is_not_null_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isNotNull($value));
    }

    /**
     * @dataProvider invalidNotNullProvider
     */
    public function test_that_is_not_null_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isNotNull($value));
    }

    /**
     * @dataProvider validTrueProvider
     */
    public function test_that_is_true_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isTrue($value));
    }

    /**
     * @dataProvider invalidTrueProvider
     */
    public function test_that_is_true_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isTrue($value));
    }

    /**
     * @dataProvider validFalseProvider
     */
    public function test_that_is_false_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isFalse($value));
    }

    /**
     * @dataProvider invalidFalseProvider
     */
    public function test_that_is_false_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isFalse($value));
    }

    /**
     * @dataProvider validEmptyProvider
     */
    public function test_that_is_empty_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isEmpty($value));
    }

    /**
     * @dataProvider invalidEmptyProvider
     */
    public function test_that_is_empty_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isEmpty($value));
    }

    /**
     * @dataProvider validNotEmptyProvider
     */
    public function test_that_is_not_empty_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isNotEmpty($value));
    }

    /**
     * @dataProvider invalidNotEmptyProvider
     */
    public function test_that_is_not_empty_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isNotEmpty($value));
    }

    /**
     * @dataProvider validBlankProvider
     */
    public function test_that_is_blank_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isBlank($value));
    }

    /**
     * @dataProvider invalidBlankProvider
     */
    public function test_that_is_blank_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isBlank($value));
    }

    /**
     * @dataProvider validNotBlankProvider
     */
    public function test_that_is_not_blank_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isNotBlank($value));
    }

    /**
     * @dataProvider invalidNotBlankProvider
     */
    public function test_that_is_not_blank_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isNotBlank($value));
    }

    /**
     * @dataProvider validAlphaProvider
     */
    public function test_that_is_alpha_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isAlpha($value));
    }

    /**
     * @dataProvider invalidAlphaProvider
     */
    public function test_that_is_alpha_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isAlpha($value));
    }

    /**
     * @dataProvider validAlnumProvider
     */
    public function test_that_is_alnum_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isAlnum($value));
    }

    /**
     * @dataProvider invalidAlnumProvider
     */
    public function test_that_is_alnum_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isAlnum($value));
    }

    /**
     * @dataProvider validAlphaDashProvider
     */
    public function test_that_is_alpha_dash_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isAlphaDash($value));
    }

    /**
     * @dataProvider invalidAlphaDashProvider
     */
    public function test_that_is_alpha_dash_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isAlphaDash($value));
    }

    /**
     * @dataProvider validAlnumDashProvider
     */
    public function test_that_is_alnum_dash_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isAlnumDash($value));
    }

    /**
     * @dataProvider invalidAlnumDashProvider
     */
    public function test_that_is_alnum_dash_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isAlnumDash($value));
    }

    /**
     * @dataProvider validDigitsProvider
     */
    public function test_that_is_digits_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isDigits($value));
    }

    /**
     * @dataProvider invalidDigitsProvider
     */
    public function test_that_is_digits_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isDigits($value));
    }

    /**
     * @dataProvider validNumericProvider
     */
    public function test_that_is_numeric_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isNumeric($value));
    }

    /**
     * @dataProvider invalidNumericProvider
     */
    public function test_that_is_numeric_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isNumeric($value));
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function test_that_is_email_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isEmail($value));
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function test_that_is_email_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isEmail($value));
    }

    /**
     * @dataProvider validIpAddressProvider
     */
    public function test_that_is_ip_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isIpAddress($value));
    }

    /**
     * @dataProvider invalidIpAddressProvider
     */
    public function test_that_is_ip_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isIpAddress($value));
    }

    /**
     * @dataProvider validIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isIpV4Address($value));
    }

    /**
     * @dataProvider invalidIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isIpV4Address($value));
    }

    /**
     * @dataProvider validIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isIpV6Address($value));
    }

    /**
     * @dataProvider invalidIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isIpV6Address($value));
    }

    /**
     * @dataProvider validUriProvider
     */
    public function test_that_is_uri_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isUri($value));
    }

    /**
     * @dataProvider invalidUriProvider
     */
    public function test_that_is_uri_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isUri($value));
    }

    /**
     * @dataProvider validUrnProvider
     */
    public function test_that_is_urn_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isUrn($value));
    }

    /**
     * @dataProvider invalidUrnProvider
     */
    public function test_that_is_urn_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isUrn($value));
    }

    /**
     * @dataProvider validUuidProvider
     */
    public function test_that_is_uuid_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isUuid($value));
    }

    /**
     * @dataProvider invalidUuidProvider
     */
    public function test_that_is_uuid_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isUuid($value));
    }

    /**
     * @dataProvider validTimezoneProvider
     */
    public function test_that_is_timezone_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isTimezone($value));
    }

    /**
     * @dataProvider invalidTimezoneProvider
     */
    public function test_that_is_timezone_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isTimezone($value));
    }

    /**
     * @dataProvider validJsonProvider
     */
    public function test_that_is_json_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isJson($value));
    }

    /**
     * @dataProvider invalidJsonProvider
     */
    public function test_that_is_json_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isJson($value));
    }

    /**
     * @dataProvider validMatchProvider
     */
    public function test_that_is_match_returns_true_for_valid_value($value, $pattern)
    {
        $this->assertTrue(Test::isMatch($value, $pattern));
    }

    /**
     * @dataProvider invalidMatchProvider
     */
    public function test_that_is_match_returns_false_for_invalid_value($value, $pattern)
    {
        $this->assertFalse(Test::isMatch($value, $pattern));
    }

    /**
     * @dataProvider validContainsProvider
     */
    public function test_that_contains_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Test::contains($value, $search));
    }

    /**
     * @dataProvider invalidContainsProvider
     */
    public function test_that_contains_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Test::contains($value, $search));
    }

    /**
     * @dataProvider validStartsWithProvider
     */
    public function test_that_starts_with_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Test::startsWith($value, $search));
    }

    /**
     * @dataProvider invalidStartsWithProvider
     */
    public function test_that_starts_with_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Test::startsWith($value, $search));
    }

    /**
     * @dataProvider validEndsWithProvider
     */
    public function test_that_ends_with_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Test::endsWith($value, $search));
    }

    /**
     * @dataProvider invalidEndsWithProvider
     */
    public function test_that_ends_with_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Test::endsWith($value, $search));
    }

    /**
     * @dataProvider validExactLengthProvider
     */
    public function test_that_exact_length_returns_true_for_valid_value($value, $length)
    {
        $this->assertTrue(Test::exactLength($value, $length));
    }

    /**
     * @dataProvider invalidExactLengthProvider
     */
    public function test_that_exact_length_returns_false_for_invalid_value($value, $length)
    {
        $this->assertFalse(Test::exactLength($value, $length));
    }

    /**
     * @dataProvider validMinLengthProvider
     */
    public function test_that_min_length_returns_true_for_valid_value($value, $minLength)
    {
        $this->assertTrue(Test::minLength($value, $minLength));
    }

    /**
     * @dataProvider invalidMinLengthProvider
     */
    public function test_that_min_length_returns_false_for_invalid_value($value, $minLength)
    {
        $this->assertFalse(Test::minLength($value, $minLength));
    }

    /**
     * @dataProvider validMaxLengthProvider
     */
    public function test_that_max_length_returns_true_for_valid_value($value, $maxLength)
    {
        $this->assertTrue(Test::maxLength($value, $maxLength));
    }

    /**
     * @dataProvider invalidMaxLengthProvider
     */
    public function test_that_max_length_returns_false_for_invalid_value($value, $maxLength)
    {
        $this->assertFalse(Test::maxLength($value, $maxLength));
    }

    /**
     * @dataProvider validRangeLengthProvider
     */
    public function test_that_range_length_returns_true_for_valid_value($value, $minLength, $maxLength)
    {
        $this->assertTrue(Test::rangeLength($value, $minLength, $maxLength));
    }

    /**
     * @dataProvider invalidRangeLengthProvider
     */
    public function test_that_range_length_returns_false_for_invalid_value($value, $minLength, $maxLength)
    {
        $this->assertFalse(Test::rangeLength($value, $minLength, $maxLength));
    }

    /**
     * @dataProvider validExactNumberProvider
     */
    public function test_that_exact_number_returns_true_for_valid_value($value, $number)
    {
        $this->assertTrue(Test::exactNumber($value, $number));
    }

    /**
     * @dataProvider invalidExactNumberProvider
     */
    public function test_that_exact_number_returns_false_for_invalid_value($value, $number)
    {
        $this->assertFalse(Test::exactNumber($value, $number));
    }

    /**
     * @dataProvider validMinNumberProvider
     */
    public function test_that_min_number_returns_true_for_valid_value($value, $minNumber)
    {
        $this->assertTrue(Test::minNumber($value, $minNumber));
    }

    /**
     * @dataProvider invalidMinNumberProvider
     */
    public function test_that_min_number_returns_false_for_invalid_value($value, $minNumber)
    {
        $this->assertFalse(Test::minNumber($value, $minNumber));
    }

    /**
     * @dataProvider validMaxNumberProvider
     */
    public function test_that_max_number_returns_true_for_valid_value($value, $maxNumber)
    {
        $this->assertTrue(Test::maxNumber($value, $maxNumber));
    }

    /**
     * @dataProvider invalidMaxNumberProvider
     */
    public function test_that_max_number_returns_false_for_invalid_value($value, $maxNumber)
    {
        $this->assertFalse(Test::maxNumber($value, $maxNumber));
    }

    /**
     * @dataProvider validRangeNumberProvider
     */
    public function test_that_range_number_returns_true_for_valid_value($value, $minNumber, $maxNumber)
    {
        $this->assertTrue(Test::rangeNumber($value, $minNumber, $maxNumber));
    }

    /**
     * @dataProvider invalidRangeNumberProvider
     */
    public function test_that_range_number_returns_false_for_invalid_value($value, $minNumber, $maxNumber)
    {
        $this->assertFalse(Test::rangeNumber($value, $minNumber, $maxNumber));
    }

    /**
     * @dataProvider validWholeNumberProvider
     */
    public function test_that_whole_number_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::wholeNumber($value));
    }

    /**
     * @dataProvider invalidWholeNumberProvider
     */
    public function test_that_whole_number_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::wholeNumber($value));
    }

    /**
     * @dataProvider validNaturalNumberProvider
     */
    public function test_that_natural_number_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::naturalNumber($value));
    }

    /**
     * @dataProvider invalidNaturalNumberProvider
     */
    public function test_that_natural_number_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::naturalNumber($value));
    }

    /**
     * @dataProvider validIntValueProvider
     */
    public function test_that_int_value_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::intValue($value));
    }

    /**
     * @dataProvider invalidIntValueProvider
     */
    public function test_that_int_value_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::intValue($value));
    }

    /**
     * @dataProvider validExactCountProvider
     */
    public function test_that_exact_count_returns_true_for_valid_value($value, $count)
    {
        $this->assertTrue(Test::exactCount($value, $count));
    }

    /**
     * @dataProvider invalidExactCountProvider
     */
    public function test_that_exact_count_returns_false_for_invalid_value($value, $count)
    {
        $this->assertFalse(Test::exactCount($value, $count));
    }

    /**
     * @dataProvider validMinCountProvider
     */
    public function test_that_min_count_returns_true_for_valid_value($value, $minCount)
    {
        $this->assertTrue(Test::minCount($value, $minCount));
    }

    /**
     * @dataProvider invalidMinCountProvider
     */
    public function test_that_min_count_returns_false_for_invalid_value($value, $minCount)
    {
        $this->assertFalse(Test::minCount($value, $minCount));
    }

    /**
     * @dataProvider validMaxCountProvider
     */
    public function test_that_max_count_returns_true_for_valid_value($value, $maxCount)
    {
        $this->assertTrue(Test::maxCount($value, $maxCount));
    }

    /**
     * @dataProvider invalidMaxCountProvider
     */
    public function test_that_max_count_returns_false_for_invalid_value($value, $maxCount)
    {
        $this->assertFalse(Test::maxCount($value, $maxCount));
    }

    /**
     * @dataProvider validRangeCountProvider
     */
    public function test_that_range_count_returns_true_for_valid_value($value, $minCount, $maxCount)
    {
        $this->assertTrue(Test::rangeCount($value, $minCount, $maxCount));
    }

    /**
     * @dataProvider invalidRangeCountProvider
     */
    public function test_that_range_count_returns_false_for_invalid_value($value, $minCount, $maxCount)
    {
        $this->assertFalse(Test::rangeCount($value, $minCount, $maxCount));
    }

    /**
     * @dataProvider validOneOfProvider
     */
    public function test_that_is_one_of_returns_true_for_valid_value($value, $choices)
    {
        $this->assertTrue(Test::isOneOf($value, $choices));
    }

    /**
     * @dataProvider invalidOneOfProvider
     */
    public function test_that_is_one_of_returns_false_for_invalid_value($value, $choices)
    {
        $this->assertFalse(Test::isOneOf($value, $choices));
    }

    /**
     * @dataProvider validKeyIssetProvider
     */
    public function test_that_key_isset_returns_true_for_valid_value($value, $key)
    {
        $this->assertTrue(Test::keyIsset($value, $key));
    }

    /**
     * @dataProvider invalidKeyIssetProvider
     */
    public function test_that_key_isset_returns_false_for_invalid_value($value, $key)
    {
        $this->assertFalse(Test::keyIsset($value, $key));
    }

    /**
     * @dataProvider validKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_returns_true_for_valid_value($value, $key)
    {
        $this->assertTrue(Test::keyNotEmpty($value, $key));
    }

    /**
     * @dataProvider invalidKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_returns_false_for_invalid_value($value, $key)
    {
        $this->assertFalse(Test::keyNotEmpty($value, $key));
    }

    /**
     * @dataProvider validEqualProvider
     */
    public function test_that_are_equal_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Test::areEqual($value1, $value2));
    }

    /**
     * @dataProvider invalidEqualProvider
     */
    public function test_that_are_equal_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Test::areEqual($value1, $value2));
    }

    /**
     * @dataProvider validNotEqualProvider
     */
    public function test_that_are_not_equal_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Test::areNotEqual($value1, $value2));
    }

    /**
     * @dataProvider invalidNotEqualProvider
     */
    public function test_that_are_not_equal_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Test::areNotEqual($value1, $value2));
    }

    /**
     * @dataProvider validSameProvider
     */
    public function test_that_are_same_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Test::areSame($value1, $value2));
    }

    /**
     * @dataProvider invalidSameProvider
     */
    public function test_that_are_same_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Test::areSame($value1, $value2));
    }

    /**
     * @dataProvider validNotSameProvider
     */
    public function test_that_are_not_same_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Test::areNotSame($value1, $value2));
    }

    /**
     * @dataProvider invalidNotSameProvider
     */
    public function test_that_are_not_same_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Test::areNotSame($value1, $value2));
    }

    /**
     * @dataProvider validSameTypeProvider
     */
    public function test_that_are_same_type_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Test::areSameType($value1, $value2));
    }

    /**
     * @dataProvider invalidSameTypeProvider
     */
    public function test_that_are_same_type_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Test::areSameType($value1, $value2));
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function test_that_is_type_returns_true_for_valid_value($value, $type)
    {
        $this->assertTrue(Test::isType($value, $type));
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function test_that_is_type_returns_false_for_invalid_value($value, $type)
    {
        $this->assertFalse(Test::isType($value, $type));
    }

    /**
     * @dataProvider validListOfProvider
     */
    public function test_that_is_list_of_returns_true_for_valid_value($value, $type)
    {
        $this->assertTrue(Test::isListOf($value, $type));
    }

    /**
     * @dataProvider invalidListOfProvider
     */
    public function test_that_is_list_of_returns_false_for_invalid_value($value, $type)
    {
        $this->assertFalse(Test::isListOf($value, $type));
    }

    /**
     * @dataProvider validJsonEncodableProvider
     */
    public function test_that_is_json_encodable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isJsonEncodable($value));
    }

    /**
     * @dataProvider invalidJsonEncodableProvider
     */
    public function test_that_is_json_encodable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isJsonEncodable($value));
    }

    /**
     * @dataProvider validSerializableProvider
     */
    public function test_that_is_serializable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isSerializable($value));
    }

    /**
     * @dataProvider invalidSerializableProvider
     */
    public function test_that_is_serializable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isSerializable($value));
    }

    /**
     * @dataProvider validTraversableProvider
     */
    public function test_that_is_traversable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isTraversable($value));
    }

    /**
     * @dataProvider invalidTraversableProvider
     */
    public function test_that_is_traversable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isTraversable($value));
    }

    /**
     * @dataProvider validCountableProvider
     */
    public function test_that_is_countable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isCountable($value));
    }

    /**
     * @dataProvider invalidCountableProvider
     */
    public function test_that_is_countable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isCountable($value));
    }

    /**
     * @dataProvider validArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isArrayAccessible($value));
    }

    /**
     * @dataProvider invalidArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isArrayAccessible($value));
    }

    /**
     * @dataProvider validComparableProvider
     */
    public function test_that_is_comparable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isComparable($value));
    }

    /**
     * @dataProvider invalidComparableProvider
     */
    public function test_that_is_comparable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isComparable($value));
    }

    /**
     * @dataProvider validEquatableProvider
     */
    public function test_that_is_equatable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::isEquatable($value));
    }

    /**
     * @dataProvider invalidEquatableProvider
     */
    public function test_that_is_equatable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::isEquatable($value));
    }

    /**
     * @dataProvider validImplementsProvider
     */
    public function test_that_implements_interface_returns_true_for_valid_value($value, $interface)
    {
        $this->assertTrue(Test::implementsInterface($value, $interface));
    }

    /**
     * @dataProvider invalidImplementsProvider
     */
    public function test_that_implements_interface_returns_false_for_invalid_value($value, $interface)
    {
        $this->assertFalse(Test::implementsInterface($value, $interface));
    }

    /**
     * @dataProvider validInstanceOfProvider
     */
    public function test_that_is_instance_of_returns_true_for_valid_value($value, $className)
    {
        $this->assertTrue(Test::isInstanceOf($value, $className));
    }

    /**
     * @dataProvider invalidInstanceOfProvider
     */
    public function test_that_is_instance_of_returns_false_for_invalid_value($value, $className)
    {
        $this->assertFalse(Test::isInstanceOf($value, $className));
    }

    /**
     * @dataProvider validSubclassOfProvider
     */
    public function test_that_is_subclass_of_returns_true_for_valid_value($value, $className)
    {
        $this->assertTrue(Test::isSubclassOf($value, $className));
    }

    /**
     * @dataProvider invalidSubclassOfProvider
     */
    public function test_that_is_subclass_of_returns_false_for_invalid_value($value, $className)
    {
        $this->assertFalse(Test::isSubclassOf($value, $className));
    }

    /**
     * @dataProvider validClassExistsProvider
     */
    public function test_that_class_exists_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::classExists($value));
    }

    /**
     * @dataProvider invalidClassExistsProvider
     */
    public function test_that_class_exists_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::classExists($value));
    }

    /**
     * @dataProvider validInterfaceExistsProvider
     */
    public function test_that_interface_exists_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Test::interfaceExists($value));
    }

    /**
     * @dataProvider invalidInterfaceExistsProvider
     */
    public function test_that_interface_exists_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Test::interfaceExists($value));
    }

    /**
     * @dataProvider validMethodExistsProvider
     */
    public function test_that_method_exists_returns_true_for_valid_value($value, $object)
    {
        $this->assertTrue(Test::methodExists($value, $object));
    }

    /**
     * @dataProvider invalidMethodExistsProvider
     */
    public function test_that_method_exists_returns_false_for_invalid_value($value, $object)
    {
        $this->assertFalse(Test::methodExists($value, $object));
    }

    /**
     * @dataProvider validPathProvider
     */
    public function test_that_is_path_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Test::isPath($value));
    }

    /**
     * @dataProvider invalidPathProvider
     */
    public function test_that_is_path_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Test::isPath($value));
    }

    /**
     * @dataProvider validFileProvider
     */
    public function test_that_is_file_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Test::isFile($value));
    }

    /**
     * @dataProvider invalidFileProvider
     */
    public function test_that_is_file_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Test::isFile($value));
    }

    /**
     * @dataProvider validDirProvider
     */
    public function test_that_is_dir_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Test::isDir($value));
    }

    /**
     * @dataProvider invalidDirProvider
     */
    public function test_that_is_dir_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Test::isDir($value));
    }

    /**
     * @dataProvider validReadableProvider
     */
    public function test_that_is_readable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Test::isReadable($value));
    }

    /**
     * @dataProvider invalidReadableProvider
     */
    public function test_that_is_readable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Test::isReadable($value));
    }

    /**
     * @dataProvider validWritableProvider
     */
    public function test_that_is_writable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Test::isWritable($value));
    }

    /**
     * @dataProvider invalidWritableProvider
     */
    public function test_that_is_writable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Test::isWritable($value));
    }
}
