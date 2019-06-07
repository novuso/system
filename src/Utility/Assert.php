<?php declare(strict_types=1);

namespace Novuso\System\Utility;

use Novuso\System\Exception\AssertionException;

/**
 * Class Assert
 */
final class Assert
{
    /**
     * Asserts that a value is scalar
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isScalar($value): void
    {
        assert(
            Validate::isScalar($value),
            static::error('isScalar', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a boolean
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isBool($value): void
    {
        assert(
            Validate::isBool($value),
            static::error('isBool', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a float
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isFloat($value): void
    {
        assert(
            Validate::isFloat($value),
            static::error('isFloat', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an integer
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isInt($value): void
    {
        assert(
            Validate::isInt($value),
            static::error('isInt', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a string
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isString($value): void
    {
        assert(
            Validate::isString($value),
            static::error('isString', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an array
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isArray($value): void
    {
        assert(
            Validate::isArray($value),
            static::error('isArray', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an object
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isObject($value): void
    {
        assert(
            Validate::isObject($value),
            static::error('isObject', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is callable
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isCallable($value): void
    {
        assert(
            Validate::isCallable($value),
            static::error('isCallable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is null
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isNull($value): void
    {
        assert(
            Validate::isNull($value),
            static::error('isNull', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not null
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isNotNull($value): void
    {
        assert(
            Validate::isNotNull($value),
            static::error('isNotNull', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is true
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isTrue($value): void
    {
        assert(
            Validate::isTrue($value),
            static::error('isTrue', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is false
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isFalse($value): void
    {
        assert(
            Validate::isFalse($value),
            static::error('isFalse', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is empty
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isEmpty($value): void
    {
        assert(
            Validate::isEmpty($value),
            static::error('isEmpty', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not empty
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isNotEmpty($value): void
    {
        assert(
            Validate::isNotEmpty($value),
            static::error('isNotEmpty', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is blank
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isBlank($value): void
    {
        assert(
            Validate::isBlank($value),
            static::error('isBlank', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not blank
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isNotBlank($value): void
    {
        assert(
            Validate::isNotBlank($value),
            static::error('isNotBlank', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphabetic
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isAlpha($value): void
    {
        assert(
            Validate::isAlpha($value),
            static::error('isAlpha', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphanumeric
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isAlnum($value): void
    {
        assert(
            Validate::isAlnum($value),
            static::error('isAlnum', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphabetic-dashed
     *
     * NOTE: dashes may include hyphens and underscores.
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isAlphaDash($value): void
    {
        assert(
            Validate::isAlphaDash($value),
            static::error('isAlphaDash', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphanumeric-dashed
     *
     * NOTE: dashes may include hyphens and underscores.
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isAlnumDash($value): void
    {
        assert(
            Validate::isAlnumDash($value),
            static::error('isAlnumDash', ['value' => $value])
        );
    }

    /**
     * Asserts that a value contains only digits
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isDigits($value): void
    {
        assert(
            Validate::isDigits($value),
            static::error('isDigits', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is numeric
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isNumeric($value): void
    {
        assert(
            Validate::isNumeric($value),
            static::error('isNumeric', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an email address
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isEmail($value): void
    {
        assert(
            Validate::isEmail($value),
            static::error('isEmail', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IP address
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isIpAddress($value): void
    {
        assert(
            Validate::isIpAddress($value),
            static::error('isIpAddress', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IPv4 address
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isIpV4Address($value): void
    {
        assert(
            Validate::isIpV4Address($value),
            static::error('isIpV4Address', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IPv6 address
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isIpV6Address($value): void
    {
        assert(
            Validate::isIpV6Address($value),
            static::error('isIpV6Address', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a URI
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isUri($value): void
    {
        assert(
            Validate::isUri($value),
            static::error('isUri', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a URN
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isUrn($value): void
    {
        assert(
            Validate::isUrn($value),
            static::error('isUrn', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a UUID
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isUuid($value): void
    {
        assert(
            Validate::isUuid($value),
            static::error('isUuid', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a timezone
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isTimezone($value): void
    {
        assert(
            Validate::isTimezone($value),
            static::error('isTimezone', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a JSON string
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isJson($value): void
    {
        assert(
            Validate::isJson($value),
            static::error('isJson', ['value' => $value])
        );
    }

    /**
     * Asserts that a value matches a regular expression
     *
     * @param mixed  $value   The value
     * @param string $pattern The regex pattern
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isMatch($value, string $pattern): void
    {
        assert(
            Validate::isMatch($value, $pattern),
            static::error('isMatch', [
                'value'   => $value,
                'pattern' => $pattern
            ])
        );
    }

    /**
     * Asserts that a value contains a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function contains($value, string $search, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::contains($value, $search, $encoding),
            static::error('contains', [
                'value'    => $value,
                'search'   => $search,
                'encoding' => $encoding
            ])
        );
    }

    /**
     * Asserts that a value starts with a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function startsWith($value, string $search, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::startsWith($value, $search, $encoding),
            static::error('startsWith', [
                'value'    => $value,
                'search'   => $search,
                'encoding' => $encoding
            ])
        );
    }

    /**
     * Asserts that a value ends with a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function endsWith($value, string $search, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::endsWith($value, $search, $encoding),
            static::error('endsWith', [
                'value'    => $value,
                'search'   => $search,
                'encoding' => $encoding
            ])
        );
    }

    /**
     * Asserts that a value has an exact string length
     *
     * @param mixed  $value    The value
     * @param int    $length   The string length
     * @param string $encoding The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function exactLength($value, int $length, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::exactLength($value, $length, $encoding),
            static::error('exactLength', [
                'value'    => $value,
                'length'   => $length,
                'encoding' => $encoding
            ])
        );
    }

    /**
     * Asserts that a value has a string length greater or equal to a minimum
     *
     * @param mixed  $value     The value
     * @param int    $minLength The minimum length
     * @param string $encoding  The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function minLength($value, int $minLength, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::minLength($value, $minLength, $encoding),
            static::error('minLength', [
                'value'     => $value,
                'minLength' => $minLength,
                'encoding'  => $encoding
            ])
        );
    }

    /**
     * Asserts that a value has a string length less or equal to a maximum
     *
     * @param mixed  $value     The value
     * @param int    $maxLength The maximum length
     * @param string $encoding  The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function maxLength($value, int $maxLength, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::maxLength($value, $maxLength, $encoding),
            static::error('maxLength', [
                'value'     => $value,
                'maxLength' => $maxLength,
                'encoding'  => $encoding
            ])
        );
    }

    /**
     * Asserts that a value has a string length within a range
     *
     * @param mixed  $value     The value
     * @param int    $minLength The minimum length
     * @param int    $maxLength The maximum length
     * @param string $encoding  The string encoding
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function rangeLength($value, int $minLength, int $maxLength, string $encoding = 'UTF-8'): void
    {
        assert(
            Validate::rangeLength($value, $minLength, $maxLength, $encoding),
            static::error('rangeLength', [
                'value'     => $value,
                'minLength' => $minLength,
                'maxLength' => $maxLength,
                'encoding'  => $encoding
            ])
        );
    }

    /**
     * Asserts that a value matches an exact numeric value
     *
     * @param mixed     $value  The value
     * @param int|float $number The numeric value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function exactNumber($value, $number): void
    {
        assert(
            Validate::exactNumber($value, $number),
            static::error('exactNumber', [
                'value'  => $value,
                'number' => $number
            ])
        );
    }

    /**
     * Asserts that a value is greater or equal to a minimum number
     *
     * @param mixed     $value     The value
     * @param int|float $minNumber The minimum number
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function minNumber($value, $minNumber): void
    {
        assert(
            Validate::minNumber($value, $minNumber),
            static::error('minNumber', [
                'value'     => $value,
                'minNumber' => $minNumber
            ])
        );
    }

    /**
     * Asserts that a value is less or equal to a maximum number
     *
     * @param mixed     $value     The value
     * @param int|float $maxNumber The maximum number
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function maxNumber($value, $maxNumber): void
    {
        assert(
            Validate::maxNumber($value, $maxNumber),
            static::error('maxNumber', [
                'value'     => $value,
                'maxNumber' => $maxNumber
            ])
        );
    }

    /**
     * Asserts that a value is within a numeric range
     *
     * @param mixed     $value     The value
     * @param int|float $minNumber The minimum number
     * @param int|float $maxNumber The maximum number
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function rangeNumber($value, $minNumber, $maxNumber): void
    {
        assert(
            Validate::rangeNumber($value, $minNumber, $maxNumber),
            static::error('rangeNumber', [
                'value'     => $value,
                'minNumber' => $minNumber,
                'maxNumber' => $maxNumber
            ])
        );
    }

    /**
     * Asserts that a value is a whole number
     *
     * A whole number is any integer value greater or equal to zero.
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function wholeNumber($value): void
    {
        assert(
            Validate::wholeNumber($value),
            static::error('wholeNumber', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a natural number
     *
     * A natural number is any integer value greater than zero.
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function naturalNumber($value): void
    {
        assert(
            Validate::naturalNumber($value),
            static::error('naturalNumber', ['value' => $value])
        );
    }

    /**
     * Asserts that a value can be cast to an integer without changing value
     *
     * Passing values include integers, integer strings, and floating-point
     * numbers with integer values.
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function intValue($value): void
    {
        assert(
            Validate::intValue($value),
            static::error('intValue', ['value' => $value])
        );
    }

    /**
     * Asserts that a value has an exact count
     *
     * @param mixed $value The value
     * @param int   $count The count
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function exactCount($value, int $count): void
    {
        assert(
            Validate::exactCount($value, $count),
            static::error('exactCount', [
                'value' => $value,
                'count' => $count
            ])
        );
    }

    /**
     * Asserts that a value has a count greater or equal to a minimum
     *
     * @param mixed $value    The value
     * @param int   $minCount The minimum count
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function minCount($value, int $minCount): void
    {
        assert(
            Validate::minCount($value, $minCount),
            static::error('minCount', [
                'value'    => $value,
                'minCount' => $minCount
            ])
        );
    }

    /**
     * Asserts that a value has a count less or equal to a maximum
     *
     * @param mixed $value    The value
     * @param int   $maxCount The maximum count
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function maxCount($value, int $maxCount): void
    {
        assert(
            Validate::maxCount($value, $maxCount),
            static::error('maxCount', [
                'value'    => $value,
                'maxCount' => $maxCount
            ])
        );
    }

    /**
     * Asserts that a value has a count within a range
     *
     * @param mixed $value    The value
     * @param int   $minCount The minimum count
     * @param int   $maxCount The maximum count
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function rangeCount($value, int $minCount, int $maxCount): void
    {
        assert(
            Validate::rangeCount($value, $minCount, $maxCount),
            static::error('rangeCount', [
                'value'    => $value,
                'minCount' => $minCount,
                'maxCount' => $maxCount
            ])
        );
    }

    /**
     * Asserts that a value is one of a set of choices
     *
     * @param mixed    $value   The value
     * @param iterable $choices The choices
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isOneOf($value, iterable $choices): void
    {
        assert(
            Validate::isOneOf($value, $choices),
            static::error('isOneOf', [
                'value'   => $value,
                'choices' => $choices
            ])
        );
    }

    /**
     * Asserts that a value is array accessible with a non-null key
     *
     * @param mixed $value The value
     * @param mixed $key   The key
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function keyIsset($value, $key): void
    {
        assert(
            Validate::keyIsset($value, $key),
            static::error('keyIsset', [
                'value' => $value,
                'key'   => $key
            ])
        );
    }

    /**
     * Asserts that a value is array accessible with a non-empty key
     *
     * @param mixed $value The value
     * @param mixed $key   The key
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function keyNotEmpty($value, $key): void
    {
        assert(
            Validate::keyNotEmpty($value, $key),
            static::error('keyNotEmpty', [
                'value' => $value,
                'key'   => $key
            ])
        );
    }

    /**
     * Asserts that two values are equal
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function areEqual($value1, $value2): void
    {
        assert(
            Validate::areEqual($value1, $value2),
            static::error('areEqual', [
                'value1' => $value1,
                'value2' => $value2
            ])
        );
    }

    /**
     * Asserts that two values are not equal
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function areNotEqual($value1, $value2): void
    {
        assert(
            Validate::areNotEqual($value1, $value2),
            static::error('areNotEqual', [
                'value1' => $value1,
                'value2' => $value2
            ])
        );
    }

    /**
     * Asserts that two values are the same
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function areSame($value1, $value2): void
    {
        assert(
            Validate::areSame($value1, $value2),
            static::error('areSame', [
                'value1' => $value1,
                'value2' => $value2
            ])
        );
    }

    /**
     * Asserts that two values are not the same
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function areNotSame($value1, $value2): void
    {
        assert(
            Validate::areNotSame($value1, $value2),
            static::error('areNotSame', [
                'value1' => $value1,
                'value2' => $value2
            ])
        );
    }

    /**
     * Asserts that two values are the same type
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function areSameType($value1, $value2): void
    {
        if (!is_object($value1) || !is_object($value2)) {
            $context = [
                'value1.type' => gettype($value1),
                'value2.type' => gettype($value2)
            ];
        } else {
            $context = [
                'value1.type' => get_class($value1),
                'value2.type' => get_class($value2)
            ];
        }

        assert(
            Validate::areSameType($value1, $value2),
            static::error('areSameType', $context)
        );
    }

    /**
     * Asserts that a value is a given type
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param mixed       $value The value
     * @param string|null $type  The type or null to accept all types
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isType($value, ?string $type): void
    {
        assert(
            Validate::isType($value, $type),
            static::error('isType', [
                'value' => $value,
                'type'  => $type
            ])
        );
    }

    /**
     * Asserts that a value is a list of a given type
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string]
     *
     * @param mixed       $value The value
     * @param string|null $type  The type or null to accept all types
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isListOf($value, ?string $type): void
    {
        assert(
            Validate::isListOf($value, $type),
            static::error('isListOf', [
                'value' => $value,
                'type'  => $type
            ])
        );
    }

    /**
     * Asserts that a value can be cast to a string
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isStringCastable($value): void
    {
        assert(
            Validate::isStringCastable($value),
            static::error('isStringCastable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value can be JSON encoded
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isJsonEncodable($value): void
    {
        assert(
            Validate::isJsonEncodable($value),
            static::error('isJsonEncodable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is traversable
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isTraversable($value): void
    {
        assert(
            Validate::isTraversable($value),
            static::error('isTraversable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is countable
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isCountable($value): void
    {
        assert(
            Validate::isCountable($value),
            static::error('isCountable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is array accessible
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isArrayAccessible($value): void
    {
        assert(
            Validate::isArrayAccessible($value),
            static::error('isArrayAccessible', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a comparable object
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isComparable($value): void
    {
        assert(
            Validate::isComparable($value),
            static::error('isComparable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an equatable object
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isEquatable($value): void
    {
        assert(
            Validate::isEquatable($value),
            static::error('isEquatable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value implements a given interface
     *
     * @param mixed  $value     The value
     * @param string $interface The fully qualified interface name
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function implementsInterface($value, string $interface): void
    {
        assert(
            Validate::implementsInterface($value, $interface),
            static::error('implementsInterface', [
                'value'     => $value,
                'interface' => $interface
            ])
        );
    }

    /**
     * Asserts that a value is an instance of a type
     *
     * @param mixed  $value     The value
     * @param string $className The fully qualified class or interface name
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isInstanceOf($value, string $className): void
    {
        assert(
            Validate::isInstanceOf($value, $className),
            static::error('isInstanceOf', [
                'value'     => $value,
                'className' => $className
            ])
        );
    }

    /**
     * Asserts that a value is an object or class with a given parent class
     *
     * @param mixed  $value     The value
     * @param string $className The fully qualified class name
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isSubclassOf($value, string $className): void
    {
        assert(
            Validate::isSubclassOf($value, $className),
            static::error('isSubclassOf', [
                'value'     => $value,
                'className' => $className
            ])
        );
    }

    /**
     * Asserts that a value is an existing fully qualified class name
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function classExists($value): void
    {
        assert(
            Validate::classExists($value),
            static::error('classExists', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing fully qualified interface name
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function interfaceExists($value): void
    {
        assert(
            Validate::interfaceExists($value),
            static::error('interfaceExists', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a method name for an object or class
     *
     * @param mixed         $value  The value
     * @param object|string $object The object or fully qualified class name
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function methodExists($value, $object): void
    {
        assert(
            Validate::methodExists($value, $object),
            static::error('methodExists', [
                'value'  => $value,
                'object' => $object
            ])
        );
    }

    /**
     * Asserts that a value is an existing file or directory path
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isPath($value): void
    {
        assert(
            Validate::isPath($value),
            static::error('isPath', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing file
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isFile($value): void
    {
        assert(
            Validate::isFile($value),
            static::error('isFile', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing directory
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isDir($value): void
    {
        assert(
            Validate::isDir($value),
            static::error('isDir', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a readable file or directory
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isReadable($value): void
    {
        assert(
            Validate::isReadable($value),
            static::error('isReadable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a writable file or directory
     *
     * @param mixed $value The value
     *
     * @return void
     *
     * @throws AssertionException
     */
    public static function isWritable($value): void
    {
        assert(
            Validate::isWritable($value),
            static::error('isWritable', ['value' => $value])
        );
    }

    /**
     * Creates an assertion exception
     *
     * @param string $method  The method name
     * @param array  $context The assertion context
     *
     * @return AssertionException
     */
    protected static function error(string $method, array $context): AssertionException
    {
        $variables = [];

        foreach ($context as $name => $value) {
            $variables[] = sprintf('%s:%s', $name, VarPrinter::toString($value));
        }

        $message = sprintf(
            '%s::%s Failed {%s}',
            ClassName::short(static::class),
            $method,
            implode(',', $variables)
        );

        return new AssertionException($message);
    }
}
