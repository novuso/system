<?php

declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Exception\AssertionException;
use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(Assert::class)]
class AssertTest extends UnitTestCase
{
    use TestDataProvider;

    #[DataProvider('validScalarProvider')]
    public function test_that_is_scalar_passes_for_valid_value($value)
    {
        Assert::isScalar($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidScalarProvider')]
    public function test_that_is_scalar_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isScalar($value);
    }

    #[DataProvider('validBoolProvider')]
    public function test_that_is_bool_passes_for_valid_value($value)
    {
        Assert::isBool($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidBoolProvider')]
    public function test_that_is_bool_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isBool($value);
    }

    #[DataProvider('validFloatProvider')]
    public function test_that_is_float_passes_for_valid_value($value)
    {
        Assert::isFloat($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidFloatProvider')]
    public function test_that_is_float_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isFloat($value);
    }

    #[DataProvider('validIntProvider')]
    public function test_that_is_int_passes_for_valid_value($value)
    {
        Assert::isInt($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidIntProvider')]
    public function test_that_is_int_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isInt($value);
    }

    #[DataProvider('validStringProvider')]
    public function test_that_is_string_passes_for_valid_value($value)
    {
        Assert::isString($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidStringProvider')]
    public function test_that_is_string_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isString($value);
    }

    #[DataProvider('validArrayProvider')]
    public function test_that_is_array_passes_for_valid_value($value)
    {
        Assert::isArray($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidArrayProvider')]
    public function test_that_is_array_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isArray($value);
    }

    #[DataProvider('validObjectProvider')]
    public function test_that_is_object_passes_for_valid_value($value)
    {
        Assert::isObject($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidObjectProvider')]
    public function test_that_is_object_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isObject($value);
    }

    #[DataProvider('validCallableProvider')]
    public function test_that_is_callable_passes_for_valid_value($value)
    {
        Assert::isCallable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidCallableProvider')]
    public function test_that_is_callable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isCallable($value);
    }

    #[DataProvider('validNullProvider')]
    public function test_that_is_null_passes_for_valid_value($value)
    {
        Assert::isNull($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNullProvider')]
    public function test_that_is_null_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isNull($value);
    }

    #[DataProvider('validNotNullProvider')]
    public function test_that_is_not_null_passes_for_valid_value($value)
    {
        Assert::isNotNull($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNotNullProvider')]
    public function test_that_is_not_null_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isNotNull($value);
    }

    #[DataProvider('validTrueProvider')]
    public function test_that_is_true_passes_for_valid_value($value)
    {
        Assert::isTrue($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidTrueProvider')]
    public function test_that_is_true_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isTrue($value);
    }

    #[DataProvider('validFalseProvider')]
    public function test_that_is_false_passes_for_valid_value($value)
    {
        Assert::isFalse($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidFalseProvider')]
    public function test_that_is_false_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isFalse($value);
    }

    #[DataProvider('validEmptyProvider')]
    public function test_that_is_empty_passes_for_valid_value($value)
    {
        Assert::isEmpty($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidEmptyProvider')]
    public function test_that_is_empty_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isEmpty($value);
    }

    #[DataProvider('validNotEmptyProvider')]
    public function test_that_is_not_empty_passes_for_valid_value($value)
    {
        Assert::isNotEmpty($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNotEmptyProvider')]
    public function test_that_is_not_empty_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isNotEmpty($value);
    }

    #[DataProvider('validBlankProvider')]
    public function test_that_is_blank_passes_for_valid_value($value)
    {
        Assert::isBlank($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidBlankProvider')]
    public function test_that_is_blank_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isBlank($value);
    }

    #[DataProvider('validNotBlankProvider')]
    public function test_that_is_not_blank_passes_for_valid_value($value)
    {
        Assert::isNotBlank($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNotBlankProvider')]
    public function test_that_is_not_blank_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isNotBlank($value);
    }

    #[DataProvider('validAlphaProvider')]
    public function test_that_is_alpha_passes_for_valid_value($value)
    {
        Assert::isAlpha($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidAlphaProvider')]
    public function test_that_is_alpha_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isAlpha($value);
    }

    #[DataProvider('validAlnumProvider')]
    public function test_that_is_alnum_passes_for_valid_value($value)
    {
        Assert::isAlnum($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidAlnumProvider')]
    public function test_that_is_alnum_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isAlnum($value);
    }

    #[DataProvider('validAlphaDashProvider')]
    public function test_that_is_alpha_dash_passes_for_valid_value($value)
    {
        Assert::isAlphaDash($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidAlphaDashProvider')]
    public function test_that_is_alpha_dash_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isAlphaDash($value);
    }

    #[DataProvider('validAlnumDashProvider')]
    public function test_that_is_alnum_dash_passes_for_valid_value($value)
    {
        Assert::isAlnumDash($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidAlnumDashProvider')]
    public function test_that_is_alnum_dash_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isAlnumDash($value);
    }

    #[DataProvider('validDigitsProvider')]
    public function test_that_is_digits_passes_for_valid_value($value)
    {
        Assert::isDigits($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidDigitsProvider')]
    public function test_that_is_digits_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isDigits($value);
    }

    #[DataProvider('validNumericProvider')]
    public function test_that_is_numeric_passes_for_valid_value($value)
    {
        Assert::isNumeric($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNumericProvider')]
    public function test_that_is_numeric_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isNumeric($value);
    }

    #[DataProvider('validEmailProvider')]
    public function test_that_is_email_passes_for_valid_value($value)
    {
        Assert::isEmail($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidEmailProvider')]
    public function test_that_is_email_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isEmail($value);
    }

    #[DataProvider('validIpAddressProvider')]
    public function test_that_is_ip_address_passes_for_valid_value($value)
    {
        Assert::isIpAddress($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidIpAddressProvider')]
    public function test_that_is_ip_address_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isIpAddress($value);
    }

    #[DataProvider('validIpV4AddressProvider')]
    public function test_that_is_ip_v4_address_passes_for_valid_value($value)
    {
        Assert::isIpV4Address($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidIpV4AddressProvider')]
    public function test_that_is_ip_v4_address_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isIpV4Address($value);
    }

    #[DataProvider('validIpV6AddressProvider')]
    public function test_that_is_ip_v6_address_passes_for_valid_value($value)
    {
        Assert::isIpV6Address($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidIpV6AddressProvider')]
    public function test_that_is_ip_v6_address_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isIpV6Address($value);
    }

    #[DataProvider('validUriProvider')]
    public function test_that_is_uri_passes_for_valid_value($value)
    {
        Assert::isUri($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidUriProvider')]
    public function test_that_is_uri_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isUri($value);
    }

    #[DataProvider('validUrnProvider')]
    public function test_that_is_urn_passes_for_valid_value($value)
    {
        Assert::isUrn($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidUrnProvider')]
    public function test_that_is_urn_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isUrn($value);
    }

    #[DataProvider('validUuidProvider')]
    public function test_that_is_uuid_passes_for_valid_value($value)
    {
        Assert::isUuid($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidUuidProvider')]
    public function test_that_is_uuid_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isUuid($value);
    }

    #[DataProvider('validTimezoneProvider')]
    public function test_that_is_timezone_passes_for_valid_value($value)
    {
        Assert::isTimezone($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidTimezoneProvider')]
    public function test_that_is_timezone_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isTimezone($value);
    }

    #[DataProvider('validJsonProvider')]
    public function test_that_is_json_passes_for_valid_value($value)
    {
        Assert::isJson($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidJsonProvider')]
    public function test_that_is_json_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isJson($value);
    }

    #[DataProvider('validMatchProvider')]
    public function test_that_is_match_passes_for_valid_value($value, $pattern)
    {
        Assert::isMatch($value, $pattern);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMatchProvider')]
    public function test_that_is_match_throws_exception_for_invalid_value($value, $pattern)
    {
        static::expectException(AssertionException::class);

        Assert::isMatch($value, $pattern);
    }

    #[DataProvider('validContainsProvider')]
    public function test_that_contains_passes_for_valid_value($value, $search)
    {
        Assert::contains($value, $search);

        static::assertTrue(true);
    }

    #[DataProvider('invalidContainsProvider')]
    public function test_that_contains_throws_exception_for_invalid_value($value, $search)
    {
        static::expectException(AssertionException::class);

        Assert::contains($value, $search);
    }

    #[DataProvider('validStartsWithProvider')]
    public function test_that_starts_with_passes_for_valid_value($value, $search)
    {
        Assert::startsWith($value, $search);

        static::assertTrue(true);
    }

    #[DataProvider('invalidStartsWithProvider')]
    public function test_that_starts_with_throws_exception_for_invalid_value($value, $search)
    {
        static::expectException(AssertionException::class);

        Assert::startsWith($value, $search);
    }

    #[DataProvider('validEndsWithProvider')]
    public function test_that_ends_with_passes_for_valid_value($value, $search)
    {
        Assert::endsWith($value, $search);

        static::assertTrue(true);
    }

    #[DataProvider('invalidEndsWithProvider')]
    public function test_that_ends_with_throws_exception_for_invalid_value($value, $search)
    {
        static::expectException(AssertionException::class);

        Assert::endsWith($value, $search);
    }

    #[DataProvider('validExactLengthProvider')]
    public function test_that_exact_length_passes_for_valid_value($value, $length)
    {
        Assert::exactLength($value, $length);

        static::assertTrue(true);
    }

    #[DataProvider('invalidExactLengthProvider')]
    public function test_that_exact_length_throws_exception_for_invalid_value($value, $length)
    {
        static::expectException(AssertionException::class);

        Assert::exactLength($value, $length);
    }

    #[DataProvider('validMinLengthProvider')]
    public function test_that_min_length_passes_for_valid_value($value, $minLength)
    {
        Assert::minLength($value, $minLength);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMinLengthProvider')]
    public function test_that_min_length_throws_exception_for_invalid_value($value, $minLength)
    {
        static::expectException(AssertionException::class);

        Assert::minLength($value, $minLength);
    }

    #[DataProvider('validMaxLengthProvider')]
    public function test_that_max_length_passes_for_valid_value($value, $maxLength)
    {
        Assert::maxLength($value, $maxLength);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMaxLengthProvider')]
    public function test_that_max_length_throws_exception_for_invalid_value($value, $maxLength)
    {
        static::expectException(AssertionException::class);

        Assert::maxLength($value, $maxLength);
    }

    #[DataProvider('validRangeLengthProvider')]
    public function test_that_range_length_passes_for_valid_value($value, $minLength, $maxLength)
    {
        Assert::rangeLength($value, $minLength, $maxLength);

        static::assertTrue(true);
    }

    #[DataProvider('invalidRangeLengthProvider')]
    public function test_that_range_length_throws_exception_for_invalid_value($value, $minLength, $maxLength)
    {
        static::expectException(AssertionException::class);

        Assert::rangeLength($value, $minLength, $maxLength);
    }

    #[DataProvider('validExactNumberProvider')]
    public function test_that_exact_number_passes_for_valid_value($value, $number)
    {
        Assert::exactNumber($value, $number);

        static::assertTrue(true);
    }

    #[DataProvider('invalidExactNumberProvider')]
    public function test_that_exact_number_throws_exception_for_invalid_value($value, $number)
    {
        static::expectException(AssertionException::class);

        Assert::exactNumber($value, $number);
    }

    #[DataProvider('validMinNumberProvider')]
    public function test_that_min_number_passes_for_valid_value($value, $minNumber)
    {
        Assert::minNumber($value, $minNumber);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMinNumberProvider')]
    public function test_that_min_number_throws_exception_for_invalid_value($value, $minNumber)
    {
        static::expectException(AssertionException::class);

        Assert::minNumber($value, $minNumber);
    }

    #[DataProvider('validMaxNumberProvider')]
    public function test_that_max_number_passes_for_valid_value($value, $maxNumber)
    {
        Assert::maxNumber($value, $maxNumber);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMaxNumberProvider')]
    public function test_that_max_number_throws_exception_for_invalid_value($value, $maxNumber)
    {
        static::expectException(AssertionException::class);

        Assert::maxNumber($value, $maxNumber);
    }

    #[DataProvider('validRangeNumberProvider')]
    public function test_that_range_number_passes_for_valid_value($value, $minNumber, $maxNumber)
    {
        Assert::rangeNumber($value, $minNumber, $maxNumber);

        static::assertTrue(true);
    }

    #[DataProvider('invalidRangeNumberProvider')]
    public function test_that_range_number_throws_exception_for_invalid_value($value, $minNumber, $maxNumber)
    {
        static::expectException(AssertionException::class);

        Assert::rangeNumber($value, $minNumber, $maxNumber);
    }

    #[DataProvider('validWholeNumberProvider')]
    public function test_that_whole_number_passes_for_valid_value($value)
    {
        Assert::wholeNumber($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidWholeNumberProvider')]
    public function test_that_whole_number_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::wholeNumber($value);
    }

    #[DataProvider('validNaturalNumberProvider')]
    public function test_that_natural_number_passes_for_valid_value($value)
    {
        Assert::naturalNumber($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNaturalNumberProvider')]
    public function test_that_natural_number_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::naturalNumber($value);
    }

    #[DataProvider('validIntValueProvider')]
    public function test_that_int_value_passes_for_valid_value($value)
    {
        Assert::intValue($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidIntValueProvider')]
    public function test_that_int_value_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::intValue($value);
    }

    #[DataProvider('validExactCountProvider')]
    public function test_that_exact_count_passes_for_valid_value($value, $count)
    {
        Assert::exactCount($value, $count);

        static::assertTrue(true);
    }

    #[DataProvider('invalidExactCountProvider')]
    public function test_that_exact_count_throws_exception_for_invalid_value($value, $count)
    {
        static::expectException(AssertionException::class);

        Assert::exactCount($value, $count);
    }

    #[DataProvider('validMinCountProvider')]
    public function test_that_min_count_passes_for_valid_value($value, $minCount)
    {
        Assert::minCount($value, $minCount);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMinCountProvider')]
    public function test_that_min_count_throws_exception_for_invalid_value($value, $minCount)
    {
        static::expectException(AssertionException::class);

        Assert::minCount($value, $minCount);
    }

    #[DataProvider('validMaxCountProvider')]
    public function test_that_max_count_passes_for_valid_value($value, $maxCount)
    {
        Assert::maxCount($value, $maxCount);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMaxCountProvider')]
    public function test_that_max_count_throws_exception_for_invalid_value($value, $maxCount)
    {
        static::expectException(AssertionException::class);

        Assert::maxCount($value, $maxCount);
    }

    #[DataProvider('validRangeCountProvider')]
    public function test_that_range_count_passes_for_valid_value($value, $minCount, $maxCount)
    {
        Assert::rangeCount($value, $minCount, $maxCount);

        static::assertTrue(true);
    }

    #[DataProvider('invalidRangeCountProvider')]
    public function test_that_range_count_throws_exception_for_invalid_value($value, $minCount, $maxCount)
    {
        static::expectException(AssertionException::class);

        Assert::rangeCount($value, $minCount, $maxCount);
    }

    #[DataProvider('validOneOfProvider')]
    public function test_that_is_one_of_passes_for_valid_value($value, $choices)
    {
        Assert::isOneOf($value, $choices);

        static::assertTrue(true);
    }

    #[DataProvider('invalidOneOfProvider')]
    public function test_that_is_one_of_throws_exception_for_invalid_value($value, $choices)
    {
        static::expectException(AssertionException::class);

        Assert::isOneOf($value, $choices);
    }

    #[DataProvider('validKeyIssetProvider')]
    public function test_that_key_isset_passes_for_valid_value($value, $key)
    {
        Assert::keyIsset($value, $key);

        static::assertTrue(true);
    }

    #[DataProvider('invalidKeyIssetProvider')]
    public function test_that_key_isset_throws_exception_for_invalid_value($value, $key)
    {
        static::expectException(AssertionException::class);

        Assert::keyIsset($value, $key);
    }

    #[DataProvider('validKeyNotEmptyProvider')]
    public function test_that_key_not_empty_passes_for_valid_value($value, $key)
    {
        Assert::keyNotEmpty($value, $key);

        static::assertTrue(true);
    }

    #[DataProvider('invalidKeyNotEmptyProvider')]
    public function test_that_key_not_empty_throws_exception_for_invalid_value($value, $key)
    {
        static::expectException(AssertionException::class);

        Assert::keyNotEmpty($value, $key);
    }

    #[DataProvider('validEqualProvider')]
    public function test_that_are_equal_passes_for_valid_value($value1, $value2)
    {
        Assert::areEqual($value1, $value2);

        static::assertTrue(true);
    }

    #[DataProvider('invalidEqualProvider')]
    public function test_that_are_equal_throws_exception_for_invalid_value($value1, $value2)
    {
        static::expectException(AssertionException::class);

        Assert::areEqual($value1, $value2);
    }

    #[DataProvider('validNotEqualProvider')]
    public function test_that_are_not_equal_passes_for_valid_value($value1, $value2)
    {
        Assert::areNotEqual($value1, $value2);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNotEqualProvider')]
    public function test_that_are_not_equal_throws_exception_for_invalid_value($value1, $value2)
    {
        static::expectException(AssertionException::class);

        Assert::areNotEqual($value1, $value2);
    }

    #[DataProvider('validSameProvider')]
    public function test_that_are_same_passes_for_valid_value($value1, $value2)
    {
        Assert::areSame($value1, $value2);

        static::assertTrue(true);
    }

    #[DataProvider('invalidSameProvider')]
    public function test_that_are_same_throws_exception_for_invalid_value($value1, $value2)
    {
        static::expectException(AssertionException::class);

        Assert::areSame($value1, $value2);
    }

    #[DataProvider('validNotSameProvider')]
    public function test_that_are_not_same_passes_for_valid_value($value1, $value2)
    {
        Assert::areNotSame($value1, $value2);

        static::assertTrue(true);
    }

    #[DataProvider('invalidNotSameProvider')]
    public function test_that_are_not_same_throws_exception_for_invalid_value($value1, $value2)
    {
        static::expectException(AssertionException::class);

        Assert::areNotSame($value1, $value2);
    }

    #[DataProvider('validSameTypeProvider')]
    public function test_that_are_same_type_passes_for_valid_value($value1, $value2)
    {
        Assert::areSameType($value1, $value2);

        static::assertTrue(true);
    }

    #[DataProvider('invalidSameTypeProvider')]
    public function test_that_are_same_type_throws_exception_for_invalid_value($value1, $value2)
    {
        static::expectException(AssertionException::class);

        Assert::areSameType($value1, $value2);
    }

    #[DataProvider('validTypeProvider')]
    public function test_that_is_type_passes_for_valid_value($value, $type)
    {
        Assert::isType($value, $type);

        static::assertTrue(true);
    }

    #[DataProvider('invalidTypeProvider')]
    public function test_that_is_type_throws_exception_for_invalid_value($value, $type)
    {
        static::expectException(AssertionException::class);

        Assert::isType($value, $type);
    }

    #[DataProvider('validListOfProvider')]
    public function test_that_is_list_of_passes_for_valid_value($value, $type)
    {
        Assert::isListOf($value, $type);

        static::assertTrue(true);
    }

    #[DataProvider('invalidListOfProvider')]
    public function test_that_is_list_of_throws_exception_for_invalid_value($value, $type)
    {
        static::expectException(AssertionException::class);

        Assert::isListOf($value, $type);
    }

    #[DataProvider('validStringCastableProvider')]
    public function test_that_is_string_castable_passes_for_valid_value($value)
    {
        Assert::isStringCastable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidStringCastableProvider')]
    public function test_that_is_string_castable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isStringCastable($value);
    }

    #[DataProvider('validJsonEncodableProvider')]
    public function test_that_is_json_encodable_passes_for_valid_value($value)
    {
        Assert::isJsonEncodable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidJsonEncodableProvider')]
    public function test_that_is_json_encodable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isJsonEncodable($value);
    }

    #[DataProvider('validTraversableProvider')]
    public function test_that_is_traversable_passes_for_valid_value($value)
    {
        Assert::isTraversable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidTraversableProvider')]
    public function test_that_is_traversable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isTraversable($value);
    }

    #[DataProvider('validCountableProvider')]
    public function test_that_is_countable_passes_for_valid_value($value)
    {
        Assert::isCountable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidCountableProvider')]
    public function test_that_is_countable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isCountable($value);
    }

    #[DataProvider('validArrayAccessibleProvider')]
    public function test_that_is_array_accessible_passes_for_valid_value($value)
    {
        Assert::isArrayAccessible($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidArrayAccessibleProvider')]
    public function test_that_is_array_accessible_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isArrayAccessible($value);
    }

    #[DataProvider('validComparableProvider')]
    public function test_that_is_comparable_passes_for_valid_value($value)
    {
        Assert::isComparable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidComparableProvider')]
    public function test_that_is_comparable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isComparable($value);
    }

    #[DataProvider('validEquatableProvider')]
    public function test_that_is_equatable_passes_for_valid_value($value)
    {
        Assert::isEquatable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidEquatableProvider')]
    public function test_that_is_equatable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::isEquatable($value);
    }

    #[DataProvider('validImplementsProvider')]
    public function test_that_implements_interface_passes_for_valid_value($value, $interface)
    {
        Assert::implementsInterface($value, $interface);

        static::assertTrue(true);
    }

    #[DataProvider('invalidImplementsProvider')]
    public function test_that_implements_interface_throws_exception_for_invalid_value($value, $interface)
    {
        static::expectException(AssertionException::class);

        Assert::implementsInterface($value, $interface);
    }

    #[DataProvider('validInstanceOfProvider')]
    public function test_that_is_instance_of_passes_for_valid_value($value, $className)
    {
        Assert::isInstanceOf($value, $className);

        static::assertTrue(true);
    }

    #[DataProvider('invalidInstanceOfProvider')]
    public function test_that_is_instance_of_throws_exception_for_invalid_value($value, $className)
    {
        static::expectException(AssertionException::class);

        Assert::isInstanceOf($value, $className);
    }

    #[DataProvider('validSubclassOfProvider')]
    public function test_that_is_subclass_of_passes_for_valid_value($value, $className)
    {
        Assert::isSubclassOf($value, $className);

        static::assertTrue(true);
    }

    #[DataProvider('invalidSubclassOfProvider')]
    public function test_that_is_subclass_of_throws_exception_for_invalid_value($value, $className)
    {
        static::expectException(AssertionException::class);

        Assert::isSubclassOf($value, $className);
    }

    #[DataProvider('validClassExistsProvider')]
    public function test_that_class_exists_passes_for_valid_value($value)
    {
        Assert::classExists($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidClassExistsProvider')]
    public function test_that_class_exists_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::classExists($value);
    }

    #[DataProvider('validInterfaceExistsProvider')]
    public function test_that_interface_exists_passes_for_valid_value($value)
    {
        Assert::interfaceExists($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidInterfaceExistsProvider')]
    public function test_that_interface_exists_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        Assert::interfaceExists($value);
    }

    #[DataProvider('validMethodExistsProvider')]
    public function test_that_method_exists_passes_for_valid_value($value, $object)
    {
        Assert::methodExists($value, $object);

        static::assertTrue(true);
    }

    #[DataProvider('invalidMethodExistsProvider')]
    public function test_that_method_exists_throws_exception_for_invalid_value($value, $object)
    {
        static::expectException(AssertionException::class);

        Assert::methodExists($value, $object);
    }

    #[DataProvider('validPathProvider')]
    public function test_that_is_path_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isPath($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidPathProvider')]
    public function test_that_is_path_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isPath($value);
    }

    #[DataProvider('validFileProvider')]
    public function test_that_is_file_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isFile($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidFileProvider')]
    public function test_that_is_file_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isFile($value);
    }

    #[DataProvider('validDirProvider')]
    public function test_that_is_dir_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isDir($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidDirProvider')]
    public function test_that_is_dir_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isDir($value);
    }

    #[DataProvider('validReadableProvider')]
    public function test_that_is_readable_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isReadable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidReadableProvider')]
    public function test_that_is_readable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isReadable($value);
    }

    #[DataProvider('validWritableProvider')]
    public function test_that_is_writable_passes_for_valid_value($value)
    {
        $this->createFilesystem();

        Assert::isWritable($value);

        static::assertTrue(true);
    }

    #[DataProvider('invalidWritableProvider')]
    public function test_that_is_writable_throws_exception_for_invalid_value($value)
    {
        static::expectException(AssertionException::class);

        $this->createFilesystem();

        Assert::isWritable($value);
    }
}
