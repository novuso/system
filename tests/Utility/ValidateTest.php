<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\Validate;

/**
 * @covers \Novuso\System\Utility\Validate
 */
class ValidateTest extends UnitTestCase
{
    use TestDataProvider;

    /**
     * @dataProvider validScalarProvider
     */
    public function test_that_is_scalar_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isScalar($value));
    }

    /**
     * @dataProvider invalidScalarProvider
     */
    public function test_that_is_scalar_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isScalar($value));
    }

    /**
     * @dataProvider validBoolProvider
     */
    public function test_that_is_bool_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isBool($value));
    }

    /**
     * @dataProvider invalidBoolProvider
     */
    public function test_that_is_bool_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isBool($value));
    }

    /**
     * @dataProvider validFloatProvider
     */
    public function test_that_is_float_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isFloat($value));
    }

    /**
     * @dataProvider invalidFloatProvider
     */
    public function test_that_is_float_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isFloat($value));
    }

    /**
     * @dataProvider validIntProvider
     */
    public function test_that_is_int_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isInt($value));
    }

    /**
     * @dataProvider invalidIntProvider
     */
    public function test_that_is_int_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isInt($value));
    }

    /**
     * @dataProvider validStringProvider
     */
    public function test_that_is_string_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isString($value));
    }

    /**
     * @dataProvider invalidStringProvider
     */
    public function test_that_is_string_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isString($value));
    }

    /**
     * @dataProvider validArrayProvider
     */
    public function test_that_is_array_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isArray($value));
    }

    /**
     * @dataProvider invalidArrayProvider
     */
    public function test_that_is_array_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isArray($value));
    }

    /**
     * @dataProvider validObjectProvider
     */
    public function test_that_is_object_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isObject($value));
    }

    /**
     * @dataProvider invalidObjectProvider
     */
    public function test_that_is_object_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isObject($value));
    }

    /**
     * @dataProvider validCallableProvider
     */
    public function test_that_is_callable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isCallable($value));
    }

    /**
     * @dataProvider invalidCallableProvider
     */
    public function test_that_is_callable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isCallable($value));
    }

    /**
     * @dataProvider validNullProvider
     */
    public function test_that_is_null_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isNull($value));
    }

    /**
     * @dataProvider invalidNullProvider
     */
    public function test_that_is_null_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isNull($value));
    }

    /**
     * @dataProvider validNotNullProvider
     */
    public function test_that_is_not_null_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isNotNull($value));
    }

    /**
     * @dataProvider invalidNotNullProvider
     */
    public function test_that_is_not_null_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isNotNull($value));
    }

    /**
     * @dataProvider validTrueProvider
     */
    public function test_that_is_true_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isTrue($value));
    }

    /**
     * @dataProvider invalidTrueProvider
     */
    public function test_that_is_true_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isTrue($value));
    }

    /**
     * @dataProvider validFalseProvider
     */
    public function test_that_is_false_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isFalse($value));
    }

    /**
     * @dataProvider invalidFalseProvider
     */
    public function test_that_is_false_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isFalse($value));
    }

    /**
     * @dataProvider validEmptyProvider
     */
    public function test_that_is_empty_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isEmpty($value));
    }

    /**
     * @dataProvider invalidEmptyProvider
     */
    public function test_that_is_empty_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isEmpty($value));
    }

    /**
     * @dataProvider validNotEmptyProvider
     */
    public function test_that_is_not_empty_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isNotEmpty($value));
    }

    /**
     * @dataProvider invalidNotEmptyProvider
     */
    public function test_that_is_not_empty_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isNotEmpty($value));
    }

    /**
     * @dataProvider validBlankProvider
     */
    public function test_that_is_blank_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isBlank($value));
    }

    /**
     * @dataProvider invalidBlankProvider
     */
    public function test_that_is_blank_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isBlank($value));
    }

    /**
     * @dataProvider validNotBlankProvider
     */
    public function test_that_is_not_blank_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isNotBlank($value));
    }

    /**
     * @dataProvider invalidNotBlankProvider
     */
    public function test_that_is_not_blank_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isNotBlank($value));
    }

    /**
     * @dataProvider validAlphaProvider
     */
    public function test_that_is_alpha_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isAlpha($value));
    }

    /**
     * @dataProvider invalidAlphaProvider
     */
    public function test_that_is_alpha_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isAlpha($value));
    }

    /**
     * @dataProvider validAlnumProvider
     */
    public function test_that_is_alnum_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isAlnum($value));
    }

    /**
     * @dataProvider invalidAlnumProvider
     */
    public function test_that_is_alnum_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isAlnum($value));
    }

    /**
     * @dataProvider validAlphaDashProvider
     */
    public function test_that_is_alpha_dash_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isAlphaDash($value));
    }

    /**
     * @dataProvider invalidAlphaDashProvider
     */
    public function test_that_is_alpha_dash_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isAlphaDash($value));
    }

    /**
     * @dataProvider validAlnumDashProvider
     */
    public function test_that_is_alnum_dash_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isAlnumDash($value));
    }

    /**
     * @dataProvider invalidAlnumDashProvider
     */
    public function test_that_is_alnum_dash_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isAlnumDash($value));
    }

    /**
     * @dataProvider validDigitsProvider
     */
    public function test_that_is_digits_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isDigits($value));
    }

    /**
     * @dataProvider invalidDigitsProvider
     */
    public function test_that_is_digits_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isDigits($value));
    }

    /**
     * @dataProvider validNumericProvider
     */
    public function test_that_is_numeric_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isNumeric($value));
    }

    /**
     * @dataProvider invalidNumericProvider
     */
    public function test_that_is_numeric_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isNumeric($value));
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function test_that_is_email_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isEmail($value));
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function test_that_is_email_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isEmail($value));
    }

    /**
     * @dataProvider validIpAddressProvider
     */
    public function test_that_is_ip_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isIpAddress($value));
    }

    /**
     * @dataProvider invalidIpAddressProvider
     */
    public function test_that_is_ip_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isIpAddress($value));
    }

    /**
     * @dataProvider validIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isIpV4Address($value));
    }

    /**
     * @dataProvider invalidIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isIpV4Address($value));
    }

    /**
     * @dataProvider validIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isIpV6Address($value));
    }

    /**
     * @dataProvider invalidIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isIpV6Address($value));
    }

    /**
     * @dataProvider validUriProvider
     */
    public function test_that_is_uri_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isUri($value));
    }

    /**
     * @dataProvider invalidUriProvider
     */
    public function test_that_is_uri_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isUri($value));
    }

    /**
     * @dataProvider validUrnProvider
     */
    public function test_that_is_urn_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isUrn($value));
    }

    /**
     * @dataProvider invalidUrnProvider
     */
    public function test_that_is_urn_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isUrn($value));
    }

    /**
     * @dataProvider validUuidProvider
     */
    public function test_that_is_uuid_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isUuid($value));
    }

    /**
     * @dataProvider invalidUuidProvider
     */
    public function test_that_is_uuid_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isUuid($value));
    }

    /**
     * @dataProvider validTimezoneProvider
     */
    public function test_that_is_timezone_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isTimezone($value));
    }

    /**
     * @dataProvider invalidTimezoneProvider
     */
    public function test_that_is_timezone_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isTimezone($value));
    }

    /**
     * @dataProvider validJsonProvider
     */
    public function test_that_is_json_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isJson($value));
    }

    /**
     * @dataProvider invalidJsonProvider
     */
    public function test_that_is_json_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isJson($value));
    }

    /**
     * @dataProvider validMatchProvider
     */
    public function test_that_is_match_returns_true_for_valid_value($value, $pattern)
    {
        $this->assertTrue(Validate::isMatch($value, $pattern));
    }

    /**
     * @dataProvider invalidMatchProvider
     */
    public function test_that_is_match_returns_false_for_invalid_value($value, $pattern)
    {
        $this->assertFalse(Validate::isMatch($value, $pattern));
    }

    /**
     * @dataProvider validContainsProvider
     */
    public function test_that_contains_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Validate::contains($value, $search));
    }

    /**
     * @dataProvider invalidContainsProvider
     */
    public function test_that_contains_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Validate::contains($value, $search));
    }

    /**
     * @dataProvider validStartsWithProvider
     */
    public function test_that_starts_with_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Validate::startsWith($value, $search));
    }

    /**
     * @dataProvider invalidStartsWithProvider
     */
    public function test_that_starts_with_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Validate::startsWith($value, $search));
    }

    /**
     * @dataProvider validEndsWithProvider
     */
    public function test_that_ends_with_returns_true_for_valid_value($value, $search)
    {
        $this->assertTrue(Validate::endsWith($value, $search));
    }

    /**
     * @dataProvider invalidEndsWithProvider
     */
    public function test_that_ends_with_returns_false_for_invalid_value($value, $search)
    {
        $this->assertFalse(Validate::endsWith($value, $search));
    }

    /**
     * @dataProvider validExactLengthProvider
     */
    public function test_that_exact_length_returns_true_for_valid_value($value, $length)
    {
        $this->assertTrue(Validate::exactLength($value, $length));
    }

    /**
     * @dataProvider invalidExactLengthProvider
     */
    public function test_that_exact_length_returns_false_for_invalid_value($value, $length)
    {
        $this->assertFalse(Validate::exactLength($value, $length));
    }

    /**
     * @dataProvider validMinLengthProvider
     */
    public function test_that_min_length_returns_true_for_valid_value($value, $minLength)
    {
        $this->assertTrue(Validate::minLength($value, $minLength));
    }

    /**
     * @dataProvider invalidMinLengthProvider
     */
    public function test_that_min_length_returns_false_for_invalid_value($value, $minLength)
    {
        $this->assertFalse(Validate::minLength($value, $minLength));
    }

    /**
     * @dataProvider validMaxLengthProvider
     */
    public function test_that_max_length_returns_true_for_valid_value($value, $maxLength)
    {
        $this->assertTrue(Validate::maxLength($value, $maxLength));
    }

    /**
     * @dataProvider invalidMaxLengthProvider
     */
    public function test_that_max_length_returns_false_for_invalid_value($value, $maxLength)
    {
        $this->assertFalse(Validate::maxLength($value, $maxLength));
    }

    /**
     * @dataProvider validRangeLengthProvider
     */
    public function test_that_range_length_returns_true_for_valid_value($value, $minLength, $maxLength)
    {
        $this->assertTrue(Validate::rangeLength($value, $minLength, $maxLength));
    }

    /**
     * @dataProvider invalidRangeLengthProvider
     */
    public function test_that_range_length_returns_false_for_invalid_value($value, $minLength, $maxLength)
    {
        $this->assertFalse(Validate::rangeLength($value, $minLength, $maxLength));
    }

    /**
     * @dataProvider validExactNumberProvider
     */
    public function test_that_exact_number_returns_true_for_valid_value($value, $number)
    {
        $this->assertTrue(Validate::exactNumber($value, $number));
    }

    /**
     * @dataProvider invalidExactNumberProvider
     */
    public function test_that_exact_number_returns_false_for_invalid_value($value, $number)
    {
        $this->assertFalse(Validate::exactNumber($value, $number));
    }

    /**
     * @dataProvider validMinNumberProvider
     */
    public function test_that_min_number_returns_true_for_valid_value($value, $minNumber)
    {
        $this->assertTrue(Validate::minNumber($value, $minNumber));
    }

    /**
     * @dataProvider invalidMinNumberProvider
     */
    public function test_that_min_number_returns_false_for_invalid_value($value, $minNumber)
    {
        $this->assertFalse(Validate::minNumber($value, $minNumber));
    }

    /**
     * @dataProvider validMaxNumberProvider
     */
    public function test_that_max_number_returns_true_for_valid_value($value, $maxNumber)
    {
        $this->assertTrue(Validate::maxNumber($value, $maxNumber));
    }

    /**
     * @dataProvider invalidMaxNumberProvider
     */
    public function test_that_max_number_returns_false_for_invalid_value($value, $maxNumber)
    {
        $this->assertFalse(Validate::maxNumber($value, $maxNumber));
    }

    /**
     * @dataProvider validRangeNumberProvider
     */
    public function test_that_range_number_returns_true_for_valid_value($value, $minNumber, $maxNumber)
    {
        $this->assertTrue(Validate::rangeNumber($value, $minNumber, $maxNumber));
    }

    /**
     * @dataProvider invalidRangeNumberProvider
     */
    public function test_that_range_number_returns_false_for_invalid_value($value, $minNumber, $maxNumber)
    {
        $this->assertFalse(Validate::rangeNumber($value, $minNumber, $maxNumber));
    }

    /**
     * @dataProvider validWholeNumberProvider
     */
    public function test_that_whole_number_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::wholeNumber($value));
    }

    /**
     * @dataProvider invalidWholeNumberProvider
     */
    public function test_that_whole_number_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::wholeNumber($value));
    }

    /**
     * @dataProvider validNaturalNumberProvider
     */
    public function test_that_natural_number_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::naturalNumber($value));
    }

    /**
     * @dataProvider invalidNaturalNumberProvider
     */
    public function test_that_natural_number_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::naturalNumber($value));
    }

    /**
     * @dataProvider validIntValueProvider
     */
    public function test_that_int_value_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::intValue($value));
    }

    /**
     * @dataProvider invalidIntValueProvider
     */
    public function test_that_int_value_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::intValue($value));
    }

    /**
     * @dataProvider validExactCountProvider
     */
    public function test_that_exact_count_returns_true_for_valid_value($value, $count)
    {
        $this->assertTrue(Validate::exactCount($value, $count));
    }

    /**
     * @dataProvider invalidExactCountProvider
     */
    public function test_that_exact_count_returns_false_for_invalid_value($value, $count)
    {
        $this->assertFalse(Validate::exactCount($value, $count));
    }

    /**
     * @dataProvider validMinCountProvider
     */
    public function test_that_min_count_returns_true_for_valid_value($value, $minCount)
    {
        $this->assertTrue(Validate::minCount($value, $minCount));
    }

    /**
     * @dataProvider invalidMinCountProvider
     */
    public function test_that_min_count_returns_false_for_invalid_value($value, $minCount)
    {
        $this->assertFalse(Validate::minCount($value, $minCount));
    }

    /**
     * @dataProvider validMaxCountProvider
     */
    public function test_that_max_count_returns_true_for_valid_value($value, $maxCount)
    {
        $this->assertTrue(Validate::maxCount($value, $maxCount));
    }

    /**
     * @dataProvider invalidMaxCountProvider
     */
    public function test_that_max_count_returns_false_for_invalid_value($value, $maxCount)
    {
        $this->assertFalse(Validate::maxCount($value, $maxCount));
    }

    /**
     * @dataProvider validRangeCountProvider
     */
    public function test_that_range_count_returns_true_for_valid_value($value, $minCount, $maxCount)
    {
        $this->assertTrue(Validate::rangeCount($value, $minCount, $maxCount));
    }

    /**
     * @dataProvider invalidRangeCountProvider
     */
    public function test_that_range_count_returns_false_for_invalid_value($value, $minCount, $maxCount)
    {
        $this->assertFalse(Validate::rangeCount($value, $minCount, $maxCount));
    }

    /**
     * @dataProvider validOneOfProvider
     */
    public function test_that_is_one_of_returns_true_for_valid_value($value, $choices)
    {
        $this->assertTrue(Validate::isOneOf($value, $choices));
    }

    /**
     * @dataProvider invalidOneOfProvider
     */
    public function test_that_is_one_of_returns_false_for_invalid_value($value, $choices)
    {
        $this->assertFalse(Validate::isOneOf($value, $choices));
    }

    /**
     * @dataProvider validKeyIssetProvider
     */
    public function test_that_key_isset_returns_true_for_valid_value($value, $key)
    {
        $this->assertTrue(Validate::keyIsset($value, $key));
    }

    /**
     * @dataProvider invalidKeyIssetProvider
     */
    public function test_that_key_isset_returns_false_for_invalid_value($value, $key)
    {
        $this->assertFalse(Validate::keyIsset($value, $key));
    }

    /**
     * @dataProvider validKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_returns_true_for_valid_value($value, $key)
    {
        $this->assertTrue(Validate::keyNotEmpty($value, $key));
    }

    /**
     * @dataProvider invalidKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_returns_false_for_invalid_value($value, $key)
    {
        $this->assertFalse(Validate::keyNotEmpty($value, $key));
    }

    /**
     * @dataProvider validEqualProvider
     */
    public function test_that_are_equal_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Validate::areEqual($value1, $value2));
    }

    /**
     * @dataProvider invalidEqualProvider
     */
    public function test_that_are_equal_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Validate::areEqual($value1, $value2));
    }

    /**
     * @dataProvider validNotEqualProvider
     */
    public function test_that_are_not_equal_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Validate::areNotEqual($value1, $value2));
    }

    /**
     * @dataProvider invalidNotEqualProvider
     */
    public function test_that_are_not_equal_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Validate::areNotEqual($value1, $value2));
    }

    /**
     * @dataProvider validSameProvider
     */
    public function test_that_are_same_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Validate::areSame($value1, $value2));
    }

    /**
     * @dataProvider invalidSameProvider
     */
    public function test_that_are_same_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Validate::areSame($value1, $value2));
    }

    /**
     * @dataProvider validNotSameProvider
     */
    public function test_that_are_not_same_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Validate::areNotSame($value1, $value2));
    }

    /**
     * @dataProvider invalidNotSameProvider
     */
    public function test_that_are_not_same_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Validate::areNotSame($value1, $value2));
    }

    /**
     * @dataProvider validSameTypeProvider
     */
    public function test_that_are_same_type_returns_true_for_valid_value($value1, $value2)
    {
        $this->assertTrue(Validate::areSameType($value1, $value2));
    }

    /**
     * @dataProvider invalidSameTypeProvider
     */
    public function test_that_are_same_type_returns_false_for_invalid_value($value1, $value2)
    {
        $this->assertFalse(Validate::areSameType($value1, $value2));
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function test_that_is_type_returns_true_for_valid_value($value, $type)
    {
        $this->assertTrue(Validate::isType($value, $type));
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function test_that_is_type_returns_false_for_invalid_value($value, $type)
    {
        $this->assertFalse(Validate::isType($value, $type));
    }

    /**
     * @dataProvider validListOfProvider
     */
    public function test_that_is_list_of_returns_true_for_valid_value($value, $type)
    {
        $this->assertTrue(Validate::isListOf($value, $type));
    }

    /**
     * @dataProvider invalidListOfProvider
     */
    public function test_that_is_list_of_returns_false_for_invalid_value($value, $type)
    {
        $this->assertFalse(Validate::isListOf($value, $type));
    }

    /**
     * @dataProvider validStringCastableProvider
     */
    public function test_that_is_string_castable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isStringCastable($value));
    }

    /**
     * @dataProvider invalidStringCastableProvider
     */
    public function test_that_is_string_castable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isStringCastable($value));
    }

    /**
     * @dataProvider validJsonEncodableProvider
     */
    public function test_that_is_json_encodable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isJsonEncodable($value));
    }

    /**
     * @dataProvider invalidJsonEncodableProvider
     */
    public function test_that_is_json_encodable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isJsonEncodable($value));
    }

    /**
     * @dataProvider validTraversableProvider
     */
    public function test_that_is_traversable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isTraversable($value));
    }

    /**
     * @dataProvider invalidTraversableProvider
     */
    public function test_that_is_traversable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isTraversable($value));
    }

    /**
     * @dataProvider validCountableProvider
     */
    public function test_that_is_countable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isCountable($value));
    }

    /**
     * @dataProvider invalidCountableProvider
     */
    public function test_that_is_countable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isCountable($value));
    }

    /**
     * @dataProvider validArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isArrayAccessible($value));
    }

    /**
     * @dataProvider invalidArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isArrayAccessible($value));
    }

    /**
     * @dataProvider validComparableProvider
     */
    public function test_that_is_comparable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isComparable($value));
    }

    /**
     * @dataProvider invalidComparableProvider
     */
    public function test_that_is_comparable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isComparable($value));
    }

    /**
     * @dataProvider validEquatableProvider
     */
    public function test_that_is_equatable_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::isEquatable($value));
    }

    /**
     * @dataProvider invalidEquatableProvider
     */
    public function test_that_is_equatable_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::isEquatable($value));
    }

    /**
     * @dataProvider validImplementsProvider
     */
    public function test_that_implements_interface_returns_true_for_valid_value($value, $interface)
    {
        $this->assertTrue(Validate::implementsInterface($value, $interface));
    }

    /**
     * @dataProvider invalidImplementsProvider
     */
    public function test_that_implements_interface_returns_false_for_invalid_value($value, $interface)
    {
        $this->assertFalse(Validate::implementsInterface($value, $interface));
    }

    /**
     * @dataProvider validInstanceOfProvider
     */
    public function test_that_is_instance_of_returns_true_for_valid_value($value, $className)
    {
        $this->assertTrue(Validate::isInstanceOf($value, $className));
    }

    /**
     * @dataProvider invalidInstanceOfProvider
     */
    public function test_that_is_instance_of_returns_false_for_invalid_value($value, $className)
    {
        $this->assertFalse(Validate::isInstanceOf($value, $className));
    }

    /**
     * @dataProvider validSubclassOfProvider
     */
    public function test_that_is_subclass_of_returns_true_for_valid_value($value, $className)
    {
        $this->assertTrue(Validate::isSubclassOf($value, $className));
    }

    /**
     * @dataProvider invalidSubclassOfProvider
     */
    public function test_that_is_subclass_of_returns_false_for_invalid_value($value, $className)
    {
        $this->assertFalse(Validate::isSubclassOf($value, $className));
    }

    /**
     * @dataProvider validClassExistsProvider
     */
    public function test_that_class_exists_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::classExists($value));
    }

    /**
     * @dataProvider invalidClassExistsProvider
     */
    public function test_that_class_exists_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::classExists($value));
    }

    /**
     * @dataProvider validInterfaceExistsProvider
     */
    public function test_that_interface_exists_returns_true_for_valid_value($value)
    {
        $this->assertTrue(Validate::interfaceExists($value));
    }

    /**
     * @dataProvider invalidInterfaceExistsProvider
     */
    public function test_that_interface_exists_returns_false_for_invalid_value($value)
    {
        $this->assertFalse(Validate::interfaceExists($value));
    }

    /**
     * @dataProvider validMethodExistsProvider
     */
    public function test_that_method_exists_returns_true_for_valid_value($value, $object)
    {
        $this->assertTrue(Validate::methodExists($value, $object));
    }

    /**
     * @dataProvider invalidMethodExistsProvider
     */
    public function test_that_method_exists_returns_false_for_invalid_value($value, $object)
    {
        $this->assertFalse(Validate::methodExists($value, $object));
    }

    /**
     * @dataProvider validPathProvider
     */
    public function test_that_is_path_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Validate::isPath($value));
    }

    /**
     * @dataProvider invalidPathProvider
     */
    public function test_that_is_path_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Validate::isPath($value));
    }

    /**
     * @dataProvider validFileProvider
     */
    public function test_that_is_file_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Validate::isFile($value));
    }

    /**
     * @dataProvider invalidFileProvider
     */
    public function test_that_is_file_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Validate::isFile($value));
    }

    /**
     * @dataProvider validDirProvider
     */
    public function test_that_is_dir_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Validate::isDir($value));
    }

    /**
     * @dataProvider invalidDirProvider
     */
    public function test_that_is_dir_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Validate::isDir($value));
    }

    /**
     * @dataProvider validReadableProvider
     */
    public function test_that_is_readable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Validate::isReadable($value));
    }

    /**
     * @dataProvider invalidReadableProvider
     */
    public function test_that_is_readable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Validate::isReadable($value));
    }

    /**
     * @dataProvider validWritableProvider
     */
    public function test_that_is_writable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();
        $this->assertTrue(Validate::isWritable($value));
    }

    /**
     * @dataProvider invalidWritableProvider
     */
    public function test_that_is_writable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();
        $this->assertFalse(Validate::isWritable($value));
    }
}
