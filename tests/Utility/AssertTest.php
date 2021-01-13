<?php

declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Exception\AssertionException;
use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\Assert;

/**
 * @covers \Novuso\System\Utility\Assert
 */
class AssertTest extends UnitTestCase
{
    use TestDataProvider;

    /**
     * @dataProvider validScalarProvider
     */
    public function test_that_is_scalar_passes_for_valid_value($value)
    {
        Assert::isScalar($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidScalarProvider
     */
    public function test_that_is_scalar_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isScalar($value);
    }

    /**
     * @dataProvider validBoolProvider
     */
    public function test_that_is_bool_passes_for_valid_value($value)
    {
        Assert::isBool($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidBoolProvider
     */
    public function test_that_is_bool_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isBool($value);
    }

    /**
     * @dataProvider validFloatProvider
     */
    public function test_that_is_float_passes_for_valid_value($value)
    {
        Assert::isFloat($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidFloatProvider
     */
    public function test_that_is_float_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isFloat($value);
    }

    /**
     * @dataProvider validIntProvider
     */
    public function test_that_is_int_passes_for_valid_value($value)
    {
        Assert::isInt($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidIntProvider
     */
    public function test_that_is_int_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isInt($value);
    }

    /**
     * @dataProvider validStringProvider
     */
    public function test_that_is_string_passes_for_valid_value($value)
    {
        Assert::isString($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidStringProvider
     */
    public function test_that_is_string_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isString($value);
    }

    /**
     * @dataProvider validArrayProvider
     */
    public function test_that_is_array_passes_for_valid_value($value)
    {
        Assert::isArray($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidArrayProvider
     */
    public function test_that_is_array_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isArray($value);
    }

    /**
     * @dataProvider validObjectProvider
     */
    public function test_that_is_object_passes_for_valid_value($value)
    {
        Assert::isObject($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidObjectProvider
     */
    public function test_that_is_object_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isObject($value);
    }

    /**
     * @dataProvider validCallableProvider
     */
    public function test_that_is_callable_passes_for_valid_value($value)
    {
        Assert::isCallable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidCallableProvider
     */
    public function test_that_is_callable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isCallable($value);
    }

    /**
     * @dataProvider validNullProvider
     */
    public function test_that_is_null_passes_for_valid_value($value)
    {
        Assert::isNull($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNullProvider
     */
    public function test_that_is_null_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isNull($value);
    }

    /**
     * @dataProvider validNotNullProvider
     */
    public function test_that_is_not_null_passes_for_valid_value($value)
    {
        Assert::isNotNull($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNotNullProvider
     */
    public function test_that_is_not_null_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isNotNull($value);
    }

    /**
     * @dataProvider validTrueProvider
     */
    public function test_that_is_true_passes_for_valid_value($value)
    {
        Assert::isTrue($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidTrueProvider
     */
    public function test_that_is_true_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isTrue($value);
    }

    /**
     * @dataProvider validFalseProvider
     */
    public function test_that_is_false_passes_for_valid_value($value)
    {
        Assert::isFalse($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidFalseProvider
     */
    public function test_that_is_false_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isFalse($value);
    }

    /**
     * @dataProvider validEmptyProvider
     */
    public function test_that_is_empty_passes_for_valid_value($value)
    {
        Assert::isEmpty($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidEmptyProvider
     */
    public function test_that_is_empty_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isEmpty($value);
    }

    /**
     * @dataProvider validNotEmptyProvider
     */
    public function test_that_is_not_empty_passes_for_valid_value($value)
    {
        Assert::isNotEmpty($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNotEmptyProvider
     */
    public function test_that_is_not_empty_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isNotEmpty($value);
    }

    /**
     * @dataProvider validBlankProvider
     */
    public function test_that_is_blank_passes_for_valid_value($value)
    {
        Assert::isBlank($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidBlankProvider
     */
    public function test_that_is_blank_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isBlank($value);
    }

    /**
     * @dataProvider validNotBlankProvider
     */
    public function test_that_is_not_blank_passes_for_valid_value($value)
    {
        Assert::isNotBlank($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNotBlankProvider
     */
    public function test_that_is_not_blank_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isNotBlank($value);
    }

    /**
     * @dataProvider validAlphaProvider
     */
    public function test_that_is_alpha_passes_for_valid_value($value)
    {
        Assert::isAlpha($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidAlphaProvider
     */
    public function test_that_is_alpha_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isAlpha($value);
    }

    /**
     * @dataProvider validAlnumProvider
     */
    public function test_that_is_alnum_passes_for_valid_value($value)
    {
        Assert::isAlnum($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidAlnumProvider
     */
    public function test_that_is_alnum_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isAlnum($value);
    }

    /**
     * @dataProvider validAlphaDashProvider
     */
    public function test_that_is_alpha_dash_passes_for_valid_value($value)
    {
        Assert::isAlphaDash($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidAlphaDashProvider
     */
    public function test_that_is_alpha_dash_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isAlphaDash($value);
    }

    /**
     * @dataProvider validAlnumDashProvider
     */
    public function test_that_is_alnum_dash_passes_for_valid_value($value)
    {
        Assert::isAlnumDash($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidAlnumDashProvider
     */
    public function test_that_is_alnum_dash_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isAlnumDash($value);
    }

    /**
     * @dataProvider validDigitsProvider
     */
    public function test_that_is_digits_passes_for_valid_value($value)
    {
        Assert::isDigits($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidDigitsProvider
     */
    public function test_that_is_digits_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isDigits($value);
    }

    /**
     * @dataProvider validNumericProvider
     */
    public function test_that_is_numeric_passes_for_valid_value($value)
    {
        Assert::isNumeric($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNumericProvider
     */
    public function test_that_is_numeric_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isNumeric($value);
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function test_that_is_email_passes_for_valid_value($value)
    {
        Assert::isEmail($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function test_that_is_email_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isEmail($value);
    }

    /**
     * @dataProvider validIpAddressProvider
     */
    public function test_that_is_ip_address_passes_for_valid_value($value)
    {
        Assert::isIpAddress($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidIpAddressProvider
     */
    public function test_that_is_ip_address_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isIpAddress($value);
    }

    /**
     * @dataProvider validIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_passes_for_valid_value($value)
    {
        Assert::isIpV4Address($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidIpV4AddressProvider
     */
    public function test_that_is_ip_v4_address_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isIpV4Address($value);
    }

    /**
     * @dataProvider validIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_passes_for_valid_value($value)
    {
        Assert::isIpV6Address($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidIpV6AddressProvider
     */
    public function test_that_is_ip_v6_address_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isIpV6Address($value);
    }

    /**
     * @dataProvider validUriProvider
     */
    public function test_that_is_uri_passes_for_valid_value($value)
    {
        Assert::isUri($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidUriProvider
     */
    public function test_that_is_uri_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isUri($value);
    }

    /**
     * @dataProvider validUrnProvider
     */
    public function test_that_is_urn_passes_for_valid_value($value)
    {
        Assert::isUrn($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidUrnProvider
     */
    public function test_that_is_urn_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isUrn($value);
    }

    /**
     * @dataProvider validUuidProvider
     */
    public function test_that_is_uuid_passes_for_valid_value($value)
    {
        Assert::isUuid($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidUuidProvider
     */
    public function test_that_is_uuid_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isUuid($value);
    }

    /**
     * @dataProvider validTimezoneProvider
     */
    public function test_that_is_timezone_passes_for_valid_value($value)
    {
        Assert::isTimezone($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidTimezoneProvider
     */
    public function test_that_is_timezone_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isTimezone($value);
    }

    /**
     * @dataProvider validJsonProvider
     */
    public function test_that_is_json_passes_for_valid_value($value)
    {
        Assert::isJson($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidJsonProvider
     */
    public function test_that_is_json_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isJson($value);
    }

    /**
     * @dataProvider validMatchProvider
     */
    public function test_that_is_match_passes_for_valid_value($value, $pattern)
    {
        Assert::isMatch($value, $pattern);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMatchProvider
     */
    public function test_that_is_match_throws_exception_for_invalid_value($value, $pattern)
    {
        $this->expectException(AssertionException::class);

        Assert::isMatch($value, $pattern);
    }

    /**
     * @dataProvider validContainsProvider
     */
    public function test_that_contains_passes_for_valid_value($value, $search)
    {
        Assert::contains($value, $search);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidContainsProvider
     */
    public function test_that_contains_throws_exception_for_invalid_value($value, $search)
    {
        $this->expectException(AssertionException::class);

        Assert::contains($value, $search);
    }

    /**
     * @dataProvider validStartsWithProvider
     */
    public function test_that_starts_with_passes_for_valid_value($value, $search)
    {
        Assert::startsWith($value, $search);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidStartsWithProvider
     */
    public function test_that_starts_with_throws_exception_for_invalid_value($value, $search)
    {
        $this->expectException(AssertionException::class);

        Assert::startsWith($value, $search);
    }

    /**
     * @dataProvider validEndsWithProvider
     */
    public function test_that_ends_with_passes_for_valid_value($value, $search)
    {
        Assert::endsWith($value, $search);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidEndsWithProvider
     */
    public function test_that_ends_with_throws_exception_for_invalid_value($value, $search)
    {
        $this->expectException(AssertionException::class);

        Assert::endsWith($value, $search);
    }

    /**
     * @dataProvider validExactLengthProvider
     */
    public function test_that_exact_length_passes_for_valid_value($value, $length)
    {
        Assert::exactLength($value, $length);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidExactLengthProvider
     */
    public function test_that_exact_length_throws_exception_for_invalid_value($value, $length)
    {
        $this->expectException(AssertionException::class);

        Assert::exactLength($value, $length);
    }

    /**
     * @dataProvider validMinLengthProvider
     */
    public function test_that_min_length_passes_for_valid_value($value, $minLength)
    {
        Assert::minLength($value, $minLength);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMinLengthProvider
     */
    public function test_that_min_length_throws_exception_for_invalid_value($value, $minLength)
    {
        $this->expectException(AssertionException::class);

        Assert::minLength($value, $minLength);
    }

    /**
     * @dataProvider validMaxLengthProvider
     */
    public function test_that_max_length_passes_for_valid_value($value, $maxLength)
    {
        Assert::maxLength($value, $maxLength);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMaxLengthProvider
     */
    public function test_that_max_length_throws_exception_for_invalid_value($value, $maxLength)
    {
        $this->expectException(AssertionException::class);

        Assert::maxLength($value, $maxLength);
    }

    /**
     * @dataProvider validRangeLengthProvider
     */
    public function test_that_range_length_passes_for_valid_value($value, $minLength, $maxLength)
    {
        Assert::rangeLength($value, $minLength, $maxLength);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidRangeLengthProvider
     */
    public function test_that_range_length_throws_exception_for_invalid_value($value, $minLength, $maxLength)
    {
        $this->expectException(AssertionException::class);

        Assert::rangeLength($value, $minLength, $maxLength);
    }

    /**
     * @dataProvider validExactNumberProvider
     */
    public function test_that_exact_number_passes_for_valid_value($value, $number)
    {
        Assert::exactNumber($value, $number);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidExactNumberProvider
     */
    public function test_that_exact_number_throws_exception_for_invalid_value($value, $number)
    {
        $this->expectException(AssertionException::class);

        Assert::exactNumber($value, $number);
    }

    /**
     * @dataProvider validMinNumberProvider
     */
    public function test_that_min_number_passes_for_valid_value($value, $minNumber)
    {
        Assert::minNumber($value, $minNumber);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMinNumberProvider
     */
    public function test_that_min_number_throws_exception_for_invalid_value($value, $minNumber)
    {
        $this->expectException(AssertionException::class);

        Assert::minNumber($value, $minNumber);
    }

    /**
     * @dataProvider validMaxNumberProvider
     */
    public function test_that_max_number_passes_for_valid_value($value, $maxNumber)
    {
        Assert::maxNumber($value, $maxNumber);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMaxNumberProvider
     */
    public function test_that_max_number_throws_exception_for_invalid_value($value, $maxNumber)
    {
        $this->expectException(AssertionException::class);

        Assert::maxNumber($value, $maxNumber);
    }

    /**
     * @dataProvider validRangeNumberProvider
     */
    public function test_that_range_number_passes_for_valid_value($value, $minNumber, $maxNumber)
    {
        Assert::rangeNumber($value, $minNumber, $maxNumber);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidRangeNumberProvider
     */
    public function test_that_range_number_throws_exception_for_invalid_value($value, $minNumber, $maxNumber)
    {
        $this->expectException(AssertionException::class);

        Assert::rangeNumber($value, $minNumber, $maxNumber);
    }

    /**
     * @dataProvider validWholeNumberProvider
     */
    public function test_that_whole_number_passes_for_valid_value($value)
    {
        Assert::wholeNumber($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidWholeNumberProvider
     */
    public function test_that_whole_number_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::wholeNumber($value);
    }

    /**
     * @dataProvider validNaturalNumberProvider
     */
    public function test_that_natural_number_passes_for_valid_value($value)
    {
        Assert::naturalNumber($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNaturalNumberProvider
     */
    public function test_that_natural_number_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::naturalNumber($value);
    }

    /**
     * @dataProvider validIntValueProvider
     */
    public function test_that_int_value_passes_for_valid_value($value)
    {
        Assert::intValue($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidIntValueProvider
     */
    public function test_that_int_value_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::intValue($value);
    }

    /**
     * @dataProvider validExactCountProvider
     */
    public function test_that_exact_count_passes_for_valid_value($value, $count)
    {
        Assert::exactCount($value, $count);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidExactCountProvider
     */
    public function test_that_exact_count_throws_exception_for_invalid_value($value, $count)
    {
        $this->expectException(AssertionException::class);

        Assert::exactCount($value, $count);
    }

    /**
     * @dataProvider validMinCountProvider
     */
    public function test_that_min_count_passes_for_valid_value($value, $minCount)
    {
        Assert::minCount($value, $minCount);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMinCountProvider
     */
    public function test_that_min_count_throws_exception_for_invalid_value($value, $minCount)
    {
        $this->expectException(AssertionException::class);

        Assert::minCount($value, $minCount);
    }

    /**
     * @dataProvider validMaxCountProvider
     */
    public function test_that_max_count_passes_for_valid_value($value, $maxCount)
    {
        Assert::maxCount($value, $maxCount);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMaxCountProvider
     */
    public function test_that_max_count_throws_exception_for_invalid_value($value, $maxCount)
    {
        $this->expectException(AssertionException::class);

        Assert::maxCount($value, $maxCount);
    }

    /**
     * @dataProvider validRangeCountProvider
     */
    public function test_that_range_count_passes_for_valid_value($value, $minCount, $maxCount)
    {
        Assert::rangeCount($value, $minCount, $maxCount);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidRangeCountProvider
     */
    public function test_that_range_count_throws_exception_for_invalid_value($value, $minCount, $maxCount)
    {
        $this->expectException(AssertionException::class);

        Assert::rangeCount($value, $minCount, $maxCount);
    }

    /**
     * @dataProvider validOneOfProvider
     */
    public function test_that_is_one_of_passes_for_valid_value($value, $choices)
    {
        Assert::isOneOf($value, $choices);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidOneOfProvider
     */
    public function test_that_is_one_of_throws_exception_for_invalid_value($value, $choices)
    {
        $this->expectException(AssertionException::class);

        Assert::isOneOf($value, $choices);
    }

    /**
     * @dataProvider validKeyIssetProvider
     */
    public function test_that_key_isset_passes_for_valid_value($value, $key)
    {
        Assert::keyIsset($value, $key);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidKeyIssetProvider
     */
    public function test_that_key_isset_throws_exception_for_invalid_value($value, $key)
    {
        $this->expectException(AssertionException::class);

        Assert::keyIsset($value, $key);
    }

    /**
     * @dataProvider validKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_passes_for_valid_value($value, $key)
    {
        Assert::keyNotEmpty($value, $key);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidKeyNotEmptyProvider
     */
    public function test_that_key_not_empty_throws_exception_for_invalid_value($value, $key)
    {
        $this->expectException(AssertionException::class);

        Assert::keyNotEmpty($value, $key);
    }

    /**
     * @dataProvider validEqualProvider
     */
    public function test_that_are_equal_passes_for_valid_value($value1, $value2)
    {
        Assert::areEqual($value1, $value2);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidEqualProvider
     */
    public function test_that_are_equal_throws_exception_for_invalid_value($value1, $value2)
    {
        $this->expectException(AssertionException::class);

        Assert::areEqual($value1, $value2);
    }

    /**
     * @dataProvider validNotEqualProvider
     */
    public function test_that_are_not_equal_passes_for_valid_value($value1, $value2)
    {
        Assert::areNotEqual($value1, $value2);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNotEqualProvider
     */
    public function test_that_are_not_equal_throws_exception_for_invalid_value($value1, $value2)
    {
        $this->expectException(AssertionException::class);

        Assert::areNotEqual($value1, $value2);
    }

    /**
     * @dataProvider validSameProvider
     */
    public function test_that_are_same_passes_for_valid_value($value1, $value2)
    {
        Assert::areSame($value1, $value2);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidSameProvider
     */
    public function test_that_are_same_throws_exception_for_invalid_value($value1, $value2)
    {
        $this->expectException(AssertionException::class);

        Assert::areSame($value1, $value2);
    }

    /**
     * @dataProvider validNotSameProvider
     */
    public function test_that_are_not_same_passes_for_valid_value($value1, $value2)
    {
        Assert::areNotSame($value1, $value2);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidNotSameProvider
     */
    public function test_that_are_not_same_throws_exception_for_invalid_value($value1, $value2)
    {
        $this->expectException(AssertionException::class);

        Assert::areNotSame($value1, $value2);
    }

    /**
     * @dataProvider validSameTypeProvider
     */
    public function test_that_are_same_type_passes_for_valid_value($value1, $value2)
    {
        Assert::areSameType($value1, $value2);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidSameTypeProvider
     */
    public function test_that_are_same_type_throws_exception_for_invalid_value($value1, $value2)
    {
        $this->expectException(AssertionException::class);

        Assert::areSameType($value1, $value2);
    }

    /**
     * @dataProvider validTypeProvider
     */
    public function test_that_is_type_passes_for_valid_value($value, $type)
    {
        Assert::isType($value, $type);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function test_that_is_type_throws_exception_for_invalid_value($value, $type)
    {
        $this->expectException(AssertionException::class);

        Assert::isType($value, $type);
    }

    /**
     * @dataProvider validListOfProvider
     */
    public function test_that_is_list_of_passes_for_valid_value($value, $type)
    {
        Assert::isListOf($value, $type);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidListOfProvider
     */
    public function test_that_is_list_of_throws_exception_for_invalid_value($value, $type)
    {
        $this->expectException(AssertionException::class);

        Assert::isListOf($value, $type);
    }

    /**
     * @dataProvider validStringCastableProvider
     */
    public function test_that_is_string_castable_passes_for_valid_value($value)
    {
        Assert::isStringCastable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidStringCastableProvider
     */
    public function test_that_is_string_castable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isStringCastable($value);
    }

    /**
     * @dataProvider validJsonEncodableProvider
     */
    public function test_that_is_json_encodable_passes_for_valid_value($value)
    {
        Assert::isJsonEncodable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidJsonEncodableProvider
     */
    public function test_that_is_json_encodable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isJsonEncodable($value);
    }

    /**
     * @dataProvider validTraversableProvider
     */
    public function test_that_is_traversable_passes_for_valid_value($value)
    {
        Assert::isTraversable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidTraversableProvider
     */
    public function test_that_is_traversable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isTraversable($value);
    }

    /**
     * @dataProvider validCountableProvider
     */
    public function test_that_is_countable_passes_for_valid_value($value)
    {
        Assert::isCountable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidCountableProvider
     */
    public function test_that_is_countable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isCountable($value);
    }

    /**
     * @dataProvider validArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_passes_for_valid_value($value)
    {
        Assert::isArrayAccessible($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidArrayAccessibleProvider
     */
    public function test_that_is_array_accessible_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isArrayAccessible($value);
    }

    /**
     * @dataProvider validComparableProvider
     */
    public function test_that_is_comparable_passes_for_valid_value($value)
    {
        Assert::isComparable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidComparableProvider
     */
    public function test_that_is_comparable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isComparable($value);
    }

    /**
     * @dataProvider validEquatableProvider
     */
    public function test_that_is_equatable_passes_for_valid_value($value)
    {
        Assert::isEquatable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidEquatableProvider
     */
    public function test_that_is_equatable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::isEquatable($value);
    }

    /**
     * @dataProvider validImplementsProvider
     */
    public function test_that_implements_interface_passes_for_valid_value($value, $interface)
    {
        Assert::implementsInterface($value, $interface);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidImplementsProvider
     */
    public function test_that_implements_interface_throws_exception_for_invalid_value($value, $interface)
    {
        $this->expectException(AssertionException::class);

        Assert::implementsInterface($value, $interface);
    }

    /**
     * @dataProvider validInstanceOfProvider
     */
    public function test_that_is_instance_of_passes_for_valid_value($value, $className)
    {
        Assert::isInstanceOf($value, $className);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidInstanceOfProvider
     */
    public function test_that_is_instance_of_throws_exception_for_invalid_value($value, $className)
    {
        $this->expectException(AssertionException::class);

        Assert::isInstanceOf($value, $className);
    }

    /**
     * @dataProvider validSubclassOfProvider
     */
    public function test_that_is_subclass_of_passes_for_valid_value($value, $className)
    {
        Assert::isSubclassOf($value, $className);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidSubclassOfProvider
     */
    public function test_that_is_subclass_of_throws_exception_for_invalid_value($value, $className)
    {
        $this->expectException(AssertionException::class);

        Assert::isSubclassOf($value, $className);
    }

    /**
     * @dataProvider validClassExistsProvider
     */
    public function test_that_class_exists_passes_for_valid_value($value)
    {
        Assert::classExists($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidClassExistsProvider
     */
    public function test_that_class_exists_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::classExists($value);
    }

    /**
     * @dataProvider validInterfaceExistsProvider
     */
    public function test_that_interface_exists_passes_for_valid_value($value)
    {
        Assert::interfaceExists($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidInterfaceExistsProvider
     */
    public function test_that_interface_exists_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        Assert::interfaceExists($value);
    }

    /**
     * @dataProvider validMethodExistsProvider
     */
    public function test_that_method_exists_passes_for_valid_value($value, $object)
    {
        Assert::methodExists($value, $object);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidMethodExistsProvider
     */
    public function test_that_method_exists_throws_exception_for_invalid_value($value, $object)
    {
        $this->expectException(AssertionException::class);

        Assert::methodExists($value, $object);
    }

    /**
     * @dataProvider validPathProvider
     */
    public function test_that_is_path_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isPath($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidPathProvider
     */
    public function test_that_is_path_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isPath($value);
    }

    /**
     * @dataProvider validFileProvider
     */
    public function test_that_is_file_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isFile($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidFileProvider
     */
    public function test_that_is_file_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isFile($value);
    }

    /**
     * @dataProvider validDirProvider
     */
    public function test_that_is_dir_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isDir($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidDirProvider
     */
    public function test_that_is_dir_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isDir($value);
    }

    /**
     * @dataProvider validReadableProvider
     */
    public function test_that_is_readable_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isReadable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidReadableProvider
     */
    public function test_that_is_readable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isReadable($value);
    }

    /**
     * @dataProvider validWritableProvider
     */
    public function test_that_is_writable_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isWritable($value);

        static::assertTrue(true);
    }

    /**
     * @dataProvider invalidWritableProvider
     */
    public function test_that_is_writable_throws_exception_for_invalid_value($value)
    {
        $this->expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isWritable($value);
    }
}
