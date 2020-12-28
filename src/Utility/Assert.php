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
     * @throws AssertionException
     */
    public static function isScalar(mixed $value): void
    {
        assert(
            Validate::isScalar($value),
            static::error('isScalar', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a boolean
     *
     * @throws AssertionException
     */
    public static function isBool(mixed $value): void
    {
        assert(
            Validate::isBool($value),
            static::error('isBool', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a float
     *
     * @throws AssertionException
     */
    public static function isFloat(mixed $value): void
    {
        assert(
            Validate::isFloat($value),
            static::error('isFloat', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an integer
     *
     * @throws AssertionException
     */
    public static function isInt(mixed $value): void
    {
        assert(
            Validate::isInt($value),
            static::error('isInt', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a string
     *
     * @throws AssertionException
     */
    public static function isString(mixed $value): void
    {
        assert(
            Validate::isString($value),
            static::error('isString', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an array
     *
     * @throws AssertionException
     */
    public static function isArray(mixed $value): void
    {
        assert(
            Validate::isArray($value),
            static::error('isArray', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an object
     *
     * @throws AssertionException
     */
    public static function isObject(mixed $value): void
    {
        assert(
            Validate::isObject($value),
            static::error('isObject', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is callable
     *
     * @throws AssertionException
     */
    public static function isCallable(mixed $value): void
    {
        assert(
            Validate::isCallable($value),
            static::error('isCallable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is null
     *
     * @throws AssertionException
     */
    public static function isNull(mixed $value): void
    {
        assert(
            Validate::isNull($value),
            static::error('isNull', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not null
     *
     * @throws AssertionException
     */
    public static function isNotNull(mixed $value): void
    {
        assert(
            Validate::isNotNull($value),
            static::error('isNotNull', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is true
     *
     * @throws AssertionException
     */
    public static function isTrue(mixed $value): void
    {
        assert(
            Validate::isTrue($value),
            static::error('isTrue', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is false
     *
     * @throws AssertionException
     */
    public static function isFalse(mixed $value): void
    {
        assert(
            Validate::isFalse($value),
            static::error('isFalse', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is empty
     *
     * @throws AssertionException
     */
    public static function isEmpty(mixed $value): void
    {
        assert(
            Validate::isEmpty($value),
            static::error('isEmpty', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not empty
     *
     * @throws AssertionException
     */
    public static function isNotEmpty(mixed $value): void
    {
        assert(
            Validate::isNotEmpty($value),
            static::error('isNotEmpty', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is blank
     *
     * @throws AssertionException
     */
    public static function isBlank(mixed $value): void
    {
        assert(
            Validate::isBlank($value),
            static::error('isBlank', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is not blank
     *
     * @throws AssertionException
     */
    public static function isNotBlank(mixed $value): void
    {
        assert(
            Validate::isNotBlank($value),
            static::error('isNotBlank', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphabetic
     *
     * @throws AssertionException
     */
    public static function isAlpha(mixed $value): void
    {
        assert(
            Validate::isAlpha($value),
            static::error('isAlpha', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is alphanumeric
     *
     * @throws AssertionException
     */
    public static function isAlnum(mixed $value): void
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
     * @throws AssertionException
     */
    public static function isAlphaDash(mixed $value): void
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
     * @throws AssertionException
     */
    public static function isAlnumDash(mixed $value): void
    {
        assert(
            Validate::isAlnumDash($value),
            static::error('isAlnumDash', ['value' => $value])
        );
    }

    /**
     * Asserts that a value contains only digits
     *
     * @throws AssertionException
     */
    public static function isDigits(mixed $value): void
    {
        assert(
            Validate::isDigits($value),
            static::error('isDigits', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is numeric
     *
     * @throws AssertionException
     */
    public static function isNumeric(mixed $value): void
    {
        assert(
            Validate::isNumeric($value),
            static::error('isNumeric', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an email address
     *
     * @throws AssertionException
     */
    public static function isEmail(mixed $value): void
    {
        assert(
            Validate::isEmail($value),
            static::error('isEmail', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IP address
     *
     * @throws AssertionException
     */
    public static function isIpAddress(mixed $value): void
    {
        assert(
            Validate::isIpAddress($value),
            static::error('isIpAddress', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IPv4 address
     *
     * @throws AssertionException
     */
    public static function isIpV4Address(mixed $value): void
    {
        assert(
            Validate::isIpV4Address($value),
            static::error('isIpV4Address', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an IPv6 address
     *
     * @throws AssertionException
     */
    public static function isIpV6Address(mixed $value): void
    {
        assert(
            Validate::isIpV6Address($value),
            static::error('isIpV6Address', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a URI
     *
     * @throws AssertionException
     */
    public static function isUri(mixed $value): void
    {
        assert(
            Validate::isUri($value),
            static::error('isUri', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a URN
     *
     * @throws AssertionException
     */
    public static function isUrn(mixed $value): void
    {
        assert(
            Validate::isUrn($value),
            static::error('isUrn', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a UUID
     *
     * @throws AssertionException
     */
    public static function isUuid(mixed $value): void
    {
        assert(
            Validate::isUuid($value),
            static::error('isUuid', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a timezone
     *
     * @throws AssertionException
     */
    public static function isTimezone(mixed $value): void
    {
        assert(
            Validate::isTimezone($value),
            static::error('isTimezone', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a JSON string
     *
     * @throws AssertionException
     */
    public static function isJson(mixed $value): void
    {
        assert(
            Validate::isJson($value),
            static::error('isJson', ['value' => $value])
        );
    }

    /**
     * Asserts that a value matches a regular expression
     *
     * @throws AssertionException
     */
    public static function isMatch(mixed $value, string $pattern): void
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
     * @throws AssertionException
     */
    public static function contains(mixed $value, string $search): void
    {
        assert(
            Validate::contains($value, $search),
            static::error('contains', [
                'value'  => $value,
                'search' => $search
            ])
        );
    }

    /**
     * Asserts that a value starts with a search string
     *
     * @throws AssertionException
     */
    public static function startsWith(mixed $value, string $search): void
    {
        assert(
            Validate::startsWith($value, $search),
            static::error('startsWith', [
                'value'  => $value,
                'search' => $search
            ])
        );
    }

    /**
     * Asserts that a value ends with a search string
     *
     * @throws AssertionException
     */
    public static function endsWith(mixed $value, string $search): void
    {
        assert(
            Validate::endsWith($value, $search),
            static::error('endsWith', [
                'value'  => $value,
                'search' => $search
            ])
        );
    }

    /**
     * Asserts that a value has an exact string length
     *
     * @throws AssertionException
     */
    public static function exactLength(mixed $value, int $length, string $encoding = 'UTF-8'): void
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
     * @throws AssertionException
     */
    public static function minLength(mixed $value, int $minLength, string $encoding = 'UTF-8'): void
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
     * @throws AssertionException
     */
    public static function maxLength(mixed $value, int $maxLength, string $encoding = 'UTF-8'): void
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
     * @throws AssertionException
     */
    public static function rangeLength(mixed $value, int $minLength, int $maxLength, string $encoding = 'UTF-8'): void
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
     * @throws AssertionException
     */
    public static function exactNumber(mixed $value, int|float $number): void
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
     * @throws AssertionException
     */
    public static function minNumber(mixed $value, int|float $minNumber): void
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
     * @throws AssertionException
     */
    public static function maxNumber(mixed $value, int|float $maxNumber): void
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
     * @throws AssertionException
     */
    public static function rangeNumber(mixed $value, int|float $minNumber, int|float $maxNumber): void
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
     * @throws AssertionException
     */
    public static function wholeNumber(mixed $value): void
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
     * @throws AssertionException
     */
    public static function naturalNumber(mixed $value): void
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
     * @throws AssertionException
     */
    public static function intValue(mixed $value): void
    {
        assert(
            Validate::intValue($value),
            static::error('intValue', ['value' => $value])
        );
    }

    /**
     * Asserts that a value has an exact count
     *
     * @throws AssertionException
     */
    public static function exactCount(mixed $value, int $count): void
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
     * @throws AssertionException
     */
    public static function minCount(mixed $value, int $minCount): void
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
     * @throws AssertionException
     */
    public static function maxCount(mixed $value, int $maxCount): void
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
     * @throws AssertionException
     */
    public static function rangeCount(mixed $value, int $minCount, int $maxCount): void
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
     * @throws AssertionException
     */
    public static function isOneOf(mixed $value, iterable $choices): void
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
     * @throws AssertionException
     */
    public static function keyIsset(mixed $value, mixed $key): void
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
     * @throws AssertionException
     */
    public static function keyNotEmpty(mixed $value, mixed $key): void
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
     * @throws AssertionException
     */
    public static function areEqual(mixed $value1, mixed $value2): void
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
     * @throws AssertionException
     */
    public static function areNotEqual(mixed $value1, mixed $value2): void
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
     * @throws AssertionException
     */
    public static function areSame(mixed $value1, mixed $value2): void
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
     * @throws AssertionException
     */
    public static function areNotSame(mixed $value1, mixed $value2): void
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
     * @throws AssertionException
     */
    public static function areSameType(mixed $value1, mixed $value2): void
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
     * @throws AssertionException
     */
    public static function isType(mixed $value, ?string $type): void
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
     * @throws AssertionException
     */
    public static function isListOf(mixed $value, ?string $type): void
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
     * @throws AssertionException
     */
    public static function isStringCastable(mixed $value): void
    {
        assert(
            Validate::isStringCastable($value),
            static::error('isStringCastable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value can be JSON encoded
     *
     * @throws AssertionException
     */
    public static function isJsonEncodable(mixed $value): void
    {
        assert(
            Validate::isJsonEncodable($value),
            static::error('isJsonEncodable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is traversable
     *
     * @throws AssertionException
     */
    public static function isTraversable(mixed $value): void
    {
        assert(
            Validate::isTraversable($value),
            static::error('isTraversable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is countable
     *
     * @throws AssertionException
     */
    public static function isCountable(mixed $value): void
    {
        assert(
            Validate::isCountable($value),
            static::error('isCountable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is array accessible
     *
     * @throws AssertionException
     */
    public static function isArrayAccessible(mixed $value): void
    {
        assert(
            Validate::isArrayAccessible($value),
            static::error('isArrayAccessible', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a comparable object
     *
     * @throws AssertionException
     */
    public static function isComparable(mixed $value): void
    {
        assert(
            Validate::isComparable($value),
            static::error('isComparable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an equatable object
     *
     * @throws AssertionException
     */
    public static function isEquatable(mixed $value): void
    {
        assert(
            Validate::isEquatable($value),
            static::error('isEquatable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value implements a given interface
     *
     * @throws AssertionException
     */
    public static function implementsInterface(mixed $value, string $interface): void
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
     * @throws AssertionException
     */
    public static function isInstanceOf(mixed $value, string $className): void
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
     * @throws AssertionException
     */
    public static function isSubclassOf(mixed $value, string $className): void
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
     * @throws AssertionException
     */
    public static function classExists(mixed $value): void
    {
        assert(
            Validate::classExists($value),
            static::error('classExists', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing fully qualified interface name
     *
     * @throws AssertionException
     */
    public static function interfaceExists(mixed $value): void
    {
        assert(
            Validate::interfaceExists($value),
            static::error('interfaceExists', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a method name for an object or class
     *
     * @throws AssertionException
     */
    public static function methodExists(mixed $value, object|string $object): void
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
     * @throws AssertionException
     */
    public static function isPath(mixed $value): void
    {
        assert(
            Validate::isPath($value),
            static::error('isPath', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing file
     *
     * @throws AssertionException
     */
    public static function isFile(mixed $value): void
    {
        assert(
            Validate::isFile($value),
            static::error('isFile', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is an existing directory
     *
     * @throws AssertionException
     */
    public static function isDir(mixed $value): void
    {
        assert(
            Validate::isDir($value),
            static::error('isDir', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a readable file or directory
     *
     * @throws AssertionException
     */
    public static function isReadable(mixed $value): void
    {
        assert(
            Validate::isReadable($value),
            static::error('isReadable', ['value' => $value])
        );
    }

    /**
     * Asserts that a value is a writable file or directory
     *
     * @throws AssertionException
     */
    public static function isWritable(mixed $value): void
    {
        assert(
            Validate::isWritable($value),
            static::error('isWritable', ['value' => $value])
        );
    }

    /**
     * Creates an assertion exception
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
