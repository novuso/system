<?php

declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\Validate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(Validate::class)]
class ValidateTest extends UnitTestCase
{
    use TestDataProvider;

    #[DataProvider('validScalarProvider')]
    public function test_that_is_scalar_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isScalar($value));
    }

    #[DataProvider('invalidScalarProvider')]
    public function test_that_is_scalar_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isScalar($value));
    }

    #[DataProvider('validBoolProvider')]
    public function test_that_is_bool_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isBool($value));
    }

    #[DataProvider('invalidBoolProvider')]
    public function test_that_is_bool_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isBool($value));
    }

    #[DataProvider('validFloatProvider')]
    public function test_that_is_float_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isFloat($value));
    }

    #[DataProvider('invalidFloatProvider')]
    public function test_that_is_float_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isFloat($value));
    }

    #[DataProvider('validIntProvider')]
    public function test_that_is_int_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isInt($value));
    }

    #[DataProvider('invalidIntProvider')]
    public function test_that_is_int_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isInt($value));
    }

    #[DataProvider('validStringProvider')]
    public function test_that_is_string_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isString($value));
    }

    #[DataProvider('invalidStringProvider')]
    public function test_that_is_string_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isString($value));
    }

    #[DataProvider('validArrayProvider')]
    public function test_that_is_array_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isArray($value));
    }

    #[DataProvider('invalidArrayProvider')]
    public function test_that_is_array_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isArray($value));
    }

    #[DataProvider('validObjectProvider')]
    public function test_that_is_object_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isObject($value));
    }

    #[DataProvider('invalidObjectProvider')]
    public function test_that_is_object_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isObject($value));
    }

    #[DataProvider('validCallableProvider')]
    public function test_that_is_callable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isCallable($value));
    }

    #[DataProvider('invalidCallableProvider')]
    public function test_that_is_callable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isCallable($value));
    }

    #[DataProvider('validNullProvider')]
    public function test_that_is_null_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isNull($value));
    }

    #[DataProvider('invalidNullProvider')]
    public function test_that_is_null_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isNull($value));
    }

    #[DataProvider('validNotNullProvider')]
    public function test_that_is_not_null_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isNotNull($value));
    }

    #[DataProvider('invalidNotNullProvider')]
    public function test_that_is_not_null_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isNotNull($value));
    }

    #[DataProvider('validTrueProvider')]
    public function test_that_is_true_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isTrue($value));
    }

    #[DataProvider('invalidTrueProvider')]
    public function test_that_is_true_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isTrue($value));
    }

    #[DataProvider('validFalseProvider')]
    public function test_that_is_false_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isFalse($value));
    }

    #[DataProvider('invalidFalseProvider')]
    public function test_that_is_false_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isFalse($value));
    }

    #[DataProvider('validEmptyProvider')]
    public function test_that_is_empty_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isEmpty($value));
    }

    #[DataProvider('invalidEmptyProvider')]
    public function test_that_is_empty_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isEmpty($value));
    }

    #[DataProvider('validNotEmptyProvider')]
    public function test_that_is_not_empty_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isNotEmpty($value));
    }

    #[DataProvider('invalidNotEmptyProvider')]
    public function test_that_is_not_empty_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isNotEmpty($value));
    }

    #[DataProvider('validBlankProvider')]
    public function test_that_is_blank_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isBlank($value));
    }

    #[DataProvider('invalidBlankProvider')]
    public function test_that_is_blank_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isBlank($value));
    }

    #[DataProvider('validNotBlankProvider')]
    public function test_that_is_not_blank_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isNotBlank($value));
    }

    #[DataProvider('invalidNotBlankProvider')]
    public function test_that_is_not_blank_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isNotBlank($value));
    }

    #[DataProvider('validAlphaProvider')]
    public function test_that_is_alpha_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isAlpha($value));
    }

    #[DataProvider('invalidAlphaProvider')]
    public function test_that_is_alpha_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isAlpha($value));
    }

    #[DataProvider('validAlnumProvider')]
    public function test_that_is_alnum_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isAlnum($value));
    }

    #[DataProvider('invalidAlnumProvider')]
    public function test_that_is_alnum_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isAlnum($value));
    }

    #[DataProvider('validAlphaDashProvider')]
    public function test_that_is_alpha_dash_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isAlphaDash($value));
    }

    #[DataProvider('invalidAlphaDashProvider')]
    public function test_that_is_alpha_dash_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isAlphaDash($value));
    }

    #[DataProvider('validAlnumDashProvider')]
    public function test_that_is_alnum_dash_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isAlnumDash($value));
    }

    #[DataProvider('invalidAlnumDashProvider')]
    public function test_that_is_alnum_dash_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isAlnumDash($value));
    }

    #[DataProvider('validDigitsProvider')]
    public function test_that_is_digits_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isDigits($value));
    }

    #[DataProvider('invalidDigitsProvider')]
    public function test_that_is_digits_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isDigits($value));
    }

    #[DataProvider('validNumericProvider')]
    public function test_that_is_numeric_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isNumeric($value));
    }

    #[DataProvider('invalidNumericProvider')]
    public function test_that_is_numeric_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isNumeric($value));
    }

    #[DataProvider('validEmailProvider')]
    public function test_that_is_email_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isEmail($value));
    }

    #[DataProvider('invalidEmailProvider')]
    public function test_that_is_email_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isEmail($value));
    }

    #[DataProvider('validIpAddressProvider')]
    public function test_that_is_ip_address_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isIpAddress($value));
    }

    #[DataProvider('invalidIpAddressProvider')]
    public function test_that_is_ip_address_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isIpAddress($value));
    }

    #[DataProvider('validIpV4AddressProvider')]
    public function test_that_is_ip_v4_address_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isIpV4Address($value));
    }

    #[DataProvider('invalidIpV4AddressProvider')]
    public function test_that_is_ip_v4_address_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isIpV4Address($value));
    }

    #[DataProvider('validIpV6AddressProvider')]
    public function test_that_is_ip_v6_address_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isIpV6Address($value));
    }

    #[DataProvider('invalidIpV6AddressProvider')]
    public function test_that_is_ip_v6_address_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isIpV6Address($value));
    }

    #[DataProvider('validUriProvider')]
    public function test_that_is_uri_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isUri($value));
    }

    #[DataProvider('invalidUriProvider')]
    public function test_that_is_uri_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isUri($value));
    }

    #[DataProvider('validUrnProvider')]
    public function test_that_is_urn_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isUrn($value));
    }

    #[DataProvider('invalidUrnProvider')]
    public function test_that_is_urn_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isUrn($value));
    }

    #[DataProvider('validUuidProvider')]
    public function test_that_is_uuid_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isUuid($value));
    }

    #[DataProvider('invalidUuidProvider')]
    public function test_that_is_uuid_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isUuid($value));
    }

    #[DataProvider('validTimezoneProvider')]
    public function test_that_is_timezone_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isTimezone($value));
    }

    #[DataProvider('invalidTimezoneProvider')]
    public function test_that_is_timezone_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isTimezone($value));
    }

    #[DataProvider('validJsonProvider')]
    public function test_that_is_json_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isJson($value));
    }

    #[DataProvider('invalidJsonProvider')]
    public function test_that_is_json_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isJson($value));
    }

    #[DataProvider('validMatchProvider')]
    public function test_that_is_match_returns_true_for_valid_value($value, $pattern)
    {
        static::assertTrue(Validate::isMatch($value, $pattern));
    }

    #[DataProvider('invalidMatchProvider')]
    public function test_that_is_match_returns_false_for_invalid_value($value, $pattern)
    {
        static::assertFalse(Validate::isMatch($value, $pattern));
    }

    #[DataProvider('validContainsProvider')]
    public function test_that_contains_returns_true_for_valid_value($value, $search)
    {
        static::assertTrue(Validate::contains($value, $search));
    }

    #[DataProvider('invalidContainsProvider')]
    public function test_that_contains_returns_false_for_invalid_value($value, $search)
    {
        static::assertFalse(Validate::contains($value, $search));
    }

    #[DataProvider('validStartsWithProvider')]
    public function test_that_starts_with_returns_true_for_valid_value($value, $search)
    {
        static::assertTrue(Validate::startsWith($value, $search));
    }

    #[DataProvider('invalidStartsWithProvider')]
    public function test_that_starts_with_returns_false_for_invalid_value($value, $search)
    {
        static::assertFalse(Validate::startsWith($value, $search));
    }

    #[DataProvider('validEndsWithProvider')]
    public function test_that_ends_with_returns_true_for_valid_value($value, $search)
    {
        static::assertTrue(Validate::endsWith($value, $search));
    }

    #[DataProvider('invalidEndsWithProvider')]
    public function test_that_ends_with_returns_false_for_invalid_value($value, $search)
    {
        static::assertFalse(Validate::endsWith($value, $search));
    }

    #[DataProvider('validExactLengthProvider')]
    public function test_that_exact_length_returns_true_for_valid_value($value, $length)
    {
        static::assertTrue(Validate::exactLength($value, $length));
    }

    #[DataProvider('invalidExactLengthProvider')]
    public function test_that_exact_length_returns_false_for_invalid_value($value, $length)
    {
        static::assertFalse(Validate::exactLength($value, $length));
    }

    #[DataProvider('validMinLengthProvider')]
    public function test_that_min_length_returns_true_for_valid_value($value, $minLength)
    {
        static::assertTrue(Validate::minLength($value, $minLength));
    }

    #[DataProvider('invalidMinLengthProvider')]
    public function test_that_min_length_returns_false_for_invalid_value($value, $minLength)
    {
        static::assertFalse(Validate::minLength($value, $minLength));
    }

    #[DataProvider('validMaxLengthProvider')]
    public function test_that_max_length_returns_true_for_valid_value($value, $maxLength)
    {
        static::assertTrue(Validate::maxLength($value, $maxLength));
    }

    #[DataProvider('invalidMaxLengthProvider')]
    public function test_that_max_length_returns_false_for_invalid_value($value, $maxLength)
    {
        static::assertFalse(Validate::maxLength($value, $maxLength));
    }

    #[DataProvider('validRangeLengthProvider')]
    public function test_that_range_length_returns_true_for_valid_value($value, $minLength, $maxLength)
    {
        static::assertTrue(Validate::rangeLength($value, $minLength, $maxLength));
    }

    #[DataProvider('invalidRangeLengthProvider')]
    public function test_that_range_length_returns_false_for_invalid_value($value, $minLength, $maxLength)
    {
        static::assertFalse(Validate::rangeLength($value, $minLength, $maxLength));
    }

    #[DataProvider('validExactNumberProvider')]
    public function test_that_exact_number_returns_true_for_valid_value($value, $number)
    {
        static::assertTrue(Validate::exactNumber($value, $number));
    }

    #[DataProvider('invalidExactNumberProvider')]
    public function test_that_exact_number_returns_false_for_invalid_value($value, $number)
    {
        static::assertFalse(Validate::exactNumber($value, $number));
    }

    #[DataProvider('validMinNumberProvider')]
    public function test_that_min_number_returns_true_for_valid_value($value, $minNumber)
    {
        static::assertTrue(Validate::minNumber($value, $minNumber));
    }

    #[DataProvider('invalidMinNumberProvider')]
    public function test_that_min_number_returns_false_for_invalid_value($value, $minNumber)
    {
        static::assertFalse(Validate::minNumber($value, $minNumber));
    }

    #[DataProvider('validMaxNumberProvider')]
    public function test_that_max_number_returns_true_for_valid_value($value, $maxNumber)
    {
        static::assertTrue(Validate::maxNumber($value, $maxNumber));
    }

    #[DataProvider('invalidMaxNumberProvider')]
    public function test_that_max_number_returns_false_for_invalid_value($value, $maxNumber)
    {
        static::assertFalse(Validate::maxNumber($value, $maxNumber));
    }

    #[DataProvider('validRangeNumberProvider')]
    public function test_that_range_number_returns_true_for_valid_value($value, $minNumber, $maxNumber)
    {
        static::assertTrue(Validate::rangeNumber($value, $minNumber, $maxNumber));
    }

    #[DataProvider('invalidRangeNumberProvider')]
    public function test_that_range_number_returns_false_for_invalid_value($value, $minNumber, $maxNumber)
    {
        static::assertFalse(Validate::rangeNumber($value, $minNumber, $maxNumber));
    }

    #[DataProvider('validWholeNumberProvider')]
    public function test_that_whole_number_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::wholeNumber($value));
    }

    #[DataProvider('invalidWholeNumberProvider')]
    public function test_that_whole_number_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::wholeNumber($value));
    }

    #[DataProvider('validNaturalNumberProvider')]
    public function test_that_natural_number_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::naturalNumber($value));
    }

    #[DataProvider('invalidNaturalNumberProvider')]
    public function test_that_natural_number_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::naturalNumber($value));
    }

    #[DataProvider('validIntValueProvider')]
    public function test_that_int_value_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::intValue($value));
    }

    #[DataProvider('invalidIntValueProvider')]
    public function test_that_int_value_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::intValue($value));
    }

    #[DataProvider('validExactCountProvider')]
    public function test_that_exact_count_returns_true_for_valid_value($value, $count)
    {
        static::assertTrue(Validate::exactCount($value, $count));
    }

    #[DataProvider('invalidExactCountProvider')]
    public function test_that_exact_count_returns_false_for_invalid_value($value, $count)
    {
        static::assertFalse(Validate::exactCount($value, $count));
    }

    #[DataProvider('validMinCountProvider')]
    public function test_that_min_count_returns_true_for_valid_value($value, $minCount)
    {
        static::assertTrue(Validate::minCount($value, $minCount));
    }

    #[DataProvider('invalidMinCountProvider')]
    public function test_that_min_count_returns_false_for_invalid_value($value, $minCount)
    {
        static::assertFalse(Validate::minCount($value, $minCount));
    }

    #[DataProvider('validMaxCountProvider')]
    public function test_that_max_count_returns_true_for_valid_value($value, $maxCount)
    {
        static::assertTrue(Validate::maxCount($value, $maxCount));
    }

    #[DataProvider('invalidMaxCountProvider')]
    public function test_that_max_count_returns_false_for_invalid_value($value, $maxCount)
    {
        static::assertFalse(Validate::maxCount($value, $maxCount));
    }

    #[DataProvider('validRangeCountProvider')]
    public function test_that_range_count_returns_true_for_valid_value($value, $minCount, $maxCount)
    {
        static::assertTrue(Validate::rangeCount($value, $minCount, $maxCount));
    }

    #[DataProvider('invalidRangeCountProvider')]
    public function test_that_range_count_returns_false_for_invalid_value($value, $minCount, $maxCount)
    {
        static::assertFalse(Validate::rangeCount($value, $minCount, $maxCount));
    }

    #[DataProvider('validOneOfProvider')]
    public function test_that_is_one_of_returns_true_for_valid_value($value, $choices)
    {
        static::assertTrue(Validate::isOneOf($value, $choices));
    }

    #[DataProvider('invalidOneOfProvider')]
    public function test_that_is_one_of_returns_false_for_invalid_value($value, $choices)
    {
        static::assertFalse(Validate::isOneOf($value, $choices));
    }

    #[DataProvider('validKeyIssetProvider')]
    public function test_that_key_isset_returns_true_for_valid_value($value, $key)
    {
        static::assertTrue(Validate::keyIsset($value, $key));
    }

    #[DataProvider('invalidKeyIssetProvider')]
    public function test_that_key_isset_returns_false_for_invalid_value($value, $key)
    {
        static::assertFalse(Validate::keyIsset($value, $key));
    }

    #[DataProvider('validKeyNotEmptyProvider')]
    public function test_that_key_not_empty_returns_true_for_valid_value($value, $key)
    {
        static::assertTrue(Validate::keyNotEmpty($value, $key));
    }

    #[DataProvider('invalidKeyNotEmptyProvider')]
    public function test_that_key_not_empty_returns_false_for_invalid_value($value, $key)
    {
        static::assertFalse(Validate::keyNotEmpty($value, $key));
    }

    #[DataProvider('validEqualProvider')]
    public function test_that_are_equal_returns_true_for_valid_value($value1, $value2)
    {
        static::assertTrue(Validate::areEqual($value1, $value2));
    }

    #[DataProvider('invalidEqualProvider')]
    public function test_that_are_equal_returns_false_for_invalid_value($value1, $value2)
    {
        static::assertFalse(Validate::areEqual($value1, $value2));
    }

    #[DataProvider('validNotEqualProvider')]
    public function test_that_are_not_equal_returns_true_for_valid_value($value1, $value2)
    {
        static::assertTrue(Validate::areNotEqual($value1, $value2));
    }

    #[DataProvider('invalidNotEqualProvider')]
    public function test_that_are_not_equal_returns_false_for_invalid_value($value1, $value2)
    {
        static::assertFalse(Validate::areNotEqual($value1, $value2));
    }

    #[DataProvider('validSameProvider')]
    public function test_that_are_same_returns_true_for_valid_value($value1, $value2)
    {
        static::assertTrue(Validate::areSame($value1, $value2));
    }

    #[DataProvider('invalidSameProvider')]
    public function test_that_are_same_returns_false_for_invalid_value($value1, $value2)
    {
        static::assertFalse(Validate::areSame($value1, $value2));
    }

    #[DataProvider('validNotSameProvider')]
    public function test_that_are_not_same_returns_true_for_valid_value($value1, $value2)
    {
        static::assertTrue(Validate::areNotSame($value1, $value2));
    }

    #[DataProvider('invalidNotSameProvider')]
    public function test_that_are_not_same_returns_false_for_invalid_value($value1, $value2)
    {
        static::assertFalse(Validate::areNotSame($value1, $value2));
    }

    #[DataProvider('validSameTypeProvider')]
    public function test_that_are_same_type_returns_true_for_valid_value($value1, $value2)
    {
        static::assertTrue(Validate::areSameType($value1, $value2));
    }

    #[DataProvider('invalidSameTypeProvider')]
    public function test_that_are_same_type_returns_false_for_invalid_value($value1, $value2)
    {
        static::assertFalse(Validate::areSameType($value1, $value2));
    }

    #[DataProvider('validTypeProvider')]
    public function test_that_is_type_returns_true_for_valid_value($value, $type)
    {
        static::assertTrue(Validate::isType($value, $type));
    }

    #[DataProvider('invalidTypeProvider')]
    public function test_that_is_type_returns_false_for_invalid_value($value, $type)
    {
        static::assertFalse(Validate::isType($value, $type));
    }

    #[DataProvider('validListOfProvider')]
    public function test_that_is_list_of_returns_true_for_valid_value($value, $type)
    {
        static::assertTrue(Validate::isListOf($value, $type));
    }

    #[DataProvider('invalidListOfProvider')]
    public function test_that_is_list_of_returns_false_for_invalid_value($value, $type)
    {
        static::assertFalse(Validate::isListOf($value, $type));
    }

    #[DataProvider('validStringCastableProvider')]
    public function test_that_is_string_castable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isStringCastable($value));
    }

    #[DataProvider('invalidStringCastableProvider')]
    public function test_that_is_string_castable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isStringCastable($value));
    }

    #[DataProvider('validJsonEncodableProvider')]
    public function test_that_is_json_encodable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isJsonEncodable($value));
    }

    #[DataProvider('invalidJsonEncodableProvider')]
    public function test_that_is_json_encodable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isJsonEncodable($value));
    }

    #[DataProvider('validTraversableProvider')]
    public function test_that_is_traversable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isTraversable($value));
    }

    #[DataProvider('invalidTraversableProvider')]
    public function test_that_is_traversable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isTraversable($value));
    }

    #[DataProvider('validCountableProvider')]
    public function test_that_is_countable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isCountable($value));
    }

    #[DataProvider('invalidCountableProvider')]
    public function test_that_is_countable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isCountable($value));
    }

    #[DataProvider('validArrayAccessibleProvider')]
    public function test_that_is_array_accessible_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isArrayAccessible($value));
    }

    #[DataProvider('invalidArrayAccessibleProvider')]
    public function test_that_is_array_accessible_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isArrayAccessible($value));
    }

    #[DataProvider('validComparableProvider')]
    public function test_that_is_comparable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isComparable($value));
    }

    #[DataProvider('invalidComparableProvider')]
    public function test_that_is_comparable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isComparable($value));
    }

    #[DataProvider('validEquatableProvider')]
    public function test_that_is_equatable_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::isEquatable($value));
    }

    #[DataProvider('invalidEquatableProvider')]
    public function test_that_is_equatable_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::isEquatable($value));
    }

    #[DataProvider('validImplementsProvider')]
    public function test_that_implements_interface_returns_true_for_valid_value($value, $interface)
    {
        static::assertTrue(Validate::implementsInterface($value, $interface));
    }

    #[DataProvider('invalidImplementsProvider')]
    public function test_that_implements_interface_returns_false_for_invalid_value($value, $interface)
    {
        static::assertFalse(Validate::implementsInterface($value, $interface));
    }

    #[DataProvider('validInstanceOfProvider')]
    public function test_that_is_instance_of_returns_true_for_valid_value($value, $className)
    {
        static::assertTrue(Validate::isInstanceOf($value, $className));
    }

    #[DataProvider('invalidInstanceOfProvider')]
    public function test_that_is_instance_of_returns_false_for_invalid_value($value, $className)
    {
        static::assertFalse(Validate::isInstanceOf($value, $className));
    }

    #[DataProvider('validSubclassOfProvider')]
    public function test_that_is_subclass_of_returns_true_for_valid_value($value, $className)
    {
        static::assertTrue(Validate::isSubclassOf($value, $className));
    }

    #[DataProvider('invalidSubclassOfProvider')]
    public function test_that_is_subclass_of_returns_false_for_invalid_value($value, $className)
    {
        static::assertFalse(Validate::isSubclassOf($value, $className));
    }

    #[DataProvider('validClassExistsProvider')]
    public function test_that_class_exists_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::classExists($value));
    }

    #[DataProvider('invalidClassExistsProvider')]
    public function test_that_class_exists_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::classExists($value));
    }

    #[DataProvider('validInterfaceExistsProvider')]
    public function test_that_interface_exists_returns_true_for_valid_value($value)
    {
        static::assertTrue(Validate::interfaceExists($value));
    }

    #[DataProvider('invalidInterfaceExistsProvider')]
    public function test_that_interface_exists_returns_false_for_invalid_value($value)
    {
        static::assertFalse(Validate::interfaceExists($value));
    }

    #[DataProvider('validMethodExistsProvider')]
    public function test_that_method_exists_returns_true_for_valid_value($value, $object)
    {
        static::assertTrue(Validate::methodExists($value, $object));
    }

    #[DataProvider('invalidMethodExistsProvider')]
    public function test_that_method_exists_returns_false_for_invalid_value($value, $object)
    {
        static::assertFalse(Validate::methodExists($value, $object));
    }

    #[DataProvider('validPathProvider')]
    public function test_that_is_path_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();

        static::assertTrue(Validate::isPath($value));
    }

    #[DataProvider('invalidPathProvider')]
    public function test_that_is_path_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();

        static::assertFalse(Validate::isPath($value));
    }

    #[DataProvider('validFileProvider')]
    public function test_that_is_file_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();

        static::assertTrue(Validate::isFile($value));
    }

    #[DataProvider('invalidFileProvider')]
    public function test_that_is_file_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();

        static::assertFalse(Validate::isFile($value));
    }

    #[DataProvider('validDirProvider')]
    public function test_that_is_dir_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();

        static::assertTrue(Validate::isDir($value));
    }

    #[DataProvider('invalidDirProvider')]
    public function test_that_is_dir_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();

        static::assertFalse(Validate::isDir($value));
    }

    #[DataProvider('validReadableProvider')]
    public function test_that_is_readable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();

        static::assertTrue(Validate::isReadable($value));
    }

    #[DataProvider('invalidReadableProvider')]
    public function test_that_is_readable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();

        static::assertFalse(Validate::isReadable($value));
    }

    #[DataProvider('validWritableProvider')]
    public function test_that_is_writable_returns_true_for_valid_value($value)
    {
        $this->createFilesystem();

        static::assertTrue(Validate::isWritable($value));
    }

    #[DataProvider('invalidWritableProvider')]
    public function test_that_is_writable_returns_false_for_invalid_value($value)
    {
        $this->createFilesystem();

        static::assertFalse(Validate::isWritable($value));
    }
}
