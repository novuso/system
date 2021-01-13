<?php

declare(strict_types=1);

namespace Novuso\System\Utility;

use ArrayAccess;
use Countable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use ReflectionClass;
use Stringable;
use Traversable;

/**
 * Class Validate
 */
final class Validate
{
    private static ?array $timezones = null;

    /**
     * Checks if value is scalar
     */
    public static function isScalar(mixed $value): bool
    {
        return is_scalar($value);
    }

    /**
     * Checks if value is a boolean
     */
    public static function isBool(mixed $value): bool
    {
        return is_bool($value);
    }

    /**
     * Checks if value is a float
     */
    public static function isFloat(mixed $value): bool
    {
        return is_float($value);
    }

    /**
     * Checks if value is an integer
     */
    public static function isInt(mixed $value): bool
    {
        return is_int($value);
    }

    /**
     * Checks if value is a string
     */
    public static function isString(mixed $value): bool
    {
        return is_string($value);
    }

    /**
     * Checks if value is an array
     */
    public static function isArray(mixed $value): bool
    {
        return is_array($value);
    }

    /**
     * Checks if value is an object
     */
    public static function isObject(mixed $value): bool
    {
        return is_object($value);
    }

    /**
     * Checks if value is callable
     */
    public static function isCallable(mixed $value): bool
    {
        return is_callable($value);
    }

    /**
     * Checks if value is null
     */
    public static function isNull(mixed $value): bool
    {
        return $value === null;
    }

    /**
     * Checks if value is not null
     */
    public static function isNotNull(mixed $value): bool
    {
        return $value !== null;
    }

    /**
     * Checks if value is true
     */
    public static function isTrue(mixed $value): bool
    {
        return $value === true;
    }

    /**
     * Checks if value is false
     */
    public static function isFalse(mixed $value): bool
    {
        return $value === false;
    }

    /**
     * Checks if value is empty
     */
    public static function isEmpty(mixed $value): bool
    {
        return empty($value);
    }

    /**
     * Checks if value is not empty
     */
    public static function isNotEmpty(mixed $value): bool
    {
        return !empty($value);
    }

    /**
     * Checks if value is blank
     */
    public static function isBlank(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return trim((string) $value) === '';
    }

    /**
     * Checks if value is not blank
     */
    public static function isNotBlank(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return trim((string) $value) !== '';
    }

    /**
     * Checks if value is alphabetic
     */
    public static function isAlpha(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z]*\z/ui', (string) $value);
    }

    /**
     * Checks if value is alphanumeric
     */
    public static function isAlnum(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z0-9]*\z/ui', (string) $value);
    }

    /**
     * Checks if value is alphabetic-dashed
     *
     * NOTE: dashes may include hyphens and underscores.
     */
    public static function isAlphaDash(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z\-_]*\z/ui', (string) $value);
    }

    /**
     * Checks if value is alphanumeric-dashed
     *
     * NOTE: dashes may include hyphens and underscores.
     */
    public static function isAlnumDash(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z0-9\-_]*\z/ui', (string) $value);
    }

    /**
     * Checks if value contains only digits
     */
    public static function isDigits(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return ctype_digit((string) $value);
    }

    /**
     * Checks if value is numeric
     */
    public static function isNumeric(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_numeric((string) $value);
    }

    /**
     * Checks if value is an email address
     */
    public static function isEmail(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Checks if value is an IP address
     */
    public static function isIpAddress(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Checks if value is an IPv4 address
     */
    public static function isIpV4Address(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $filtered = filter_var(
            (string) $value,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4
        );

        return $filtered !== false;
    }

    /**
     * Checks if value is an IPv6 address
     */
    public static function isIpV6Address(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $filtered = filter_var(
            (string) $value,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV6
        );

        return $filtered !== false;
    }

    /**
     * Checks if value is a URI
     */
    public static function isUri(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        // http://tools.ietf.org/html/rfc3986
        //
        // URI         = scheme ":" hier-part [ "?" query ] [ "#" fragment ]
        // hier-part   = "//" authority path-abempty
        //             / path-absolute
        //             / path-rootless
        //             / path-empty
        $pattern = sprintf(
            '/\A%s%s%s%s%s\z/',
            '(?:([^:\/?#]+)(:))?',
            '(?:(\/\/)([^\/?#]*))?',
            '([^?#]*)',
            '(?:(\?)([^#]*))?',
            '(?:(#)(.*))?'
        );

        preg_match($pattern, (string) $value, $matches);
        $uri = self::uriComponentsFromMatches($matches);

        return self::isValidUri($uri);
    }

    /**
     * Checks if value is a URN
     */
    public static function isUrn(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        // http://tools.ietf.org/html/rfc2141#section-2.1
        // To avoid confusion with the "urn:" identifier, the NID "urn" is
        // reserved and MUST NOT be used
        if (substr((string) $value, 0, 8) === "urn:urn:") {
            return false;
        }

        // http://tools.ietf.org/html/rfc2141
        //
        // <URN> ::= "urn:" <NID> ":" <NSS>
        //
        // <NID> ::= <let-num> [ 1,31<let-num-hyp> ]
        // <let-num-hyp> ::= <upper> | <lower> | <number> | "-"
        // <let-num>     ::= <upper> | <lower> | <number>
        // <upper>       ::= "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" |
        //                   "I" | "J" | "K" | "L" | "M" | "N" | "O" | "P" |
        //                   "Q" | "R" | "S" | "T" | "U" | "V" | "W" | "X" |
        //                   "Y" | "Z"
        // <lower>       ::= "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" |
        //                   "i" | "j" | "k" | "l" | "m" | "n" | "o" | "p" |
        //                   "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x" |
        //                   "y" | "z"
        // <number>      ::= "0" | "1" | "2" | "3" | "4" | "5" | "6" | "7" |
        //                   "8" | "9"
        //
        // <NSS>         ::= 1*<URN chars>
        // <URN chars>   ::= <trans> | "%" <hex> <hex>
        // <trans>       ::= <upper> | <lower> | <number> | <other> | <reserved>
        // <hex>         ::= <number> | "A" | "B" | "C" | "D" | "E" | "F" |
        //                   "a" | "b" | "c" | "d" | "e" | "f"
        // <other>       ::= "(" | ")" | "+" | "," | "-" | "." |
        //                   ":" | "=" | "@" | ";" | "$" |
        //                   "_" | "!" | "*" | "'"
        //
        // Therefore, these characters are RESERVED for future developments.
        // Namespace developers SHOULD NOT use these characters in unencoded
        // form, but rather use the appropriate %-encoding for each character.
        //
        // In addition, octet 0 (0 hex) should NEVER be used, in either
        // unencoded or %-encoded form.
        $pattern = sprintf(
            '/\Aurn:%s:%s\z/i',
            '[a-z0-9](?:[a-z0-9\-]{1,31})?',
            '(?:[a-z0-9()+,\-.:=@;$_!*\']|%(?:0[a-f1-9]|[a-f1-9][a-f0-9]))+'
        );

        return !!preg_match($pattern, (string) $value);
    }

    /**
     * Checks if value is a UUID
     */
    public static function isUuid(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        // http://tools.ietf.org/html/rfc4122
        //
        // UUID                   = time-low "-" time-mid "-"
        //                          time-high-and-version "-"
        //                          clock-seq-and-reserved
        //                          clock-seq-low "-" node
        // time-low               = 4hexOctet
        // time-mid               = 2hexOctet
        // time-high-and-version  = 2hexOctet
        // clock-seq-and-reserved = hexOctet
        // clock-seq-low          = hexOctet
        // node                   = 6hexOctet
        // hexOctet               = hexDigit hexDigit
        // hexDigit =
        //       "0" / "1" / "2" / "3" / "4" / "5" / "6" / "7" / "8" / "9" /
        //       "a" / "b" / "c" / "d" / "e" / "f" /
        //       "A" / "B" / "C" / "D" / "E" / "F"
        $pattern = sprintf(
            '/\A%s-%s-%s-%s%s-%s\z/i',
            '[a-f0-9]{8}',
            '[a-f0-9]{4}',
            '[a-f0-9]{4}',
            '[a-f0-9]{2}',
            '[a-f0-9]{2}',
            '[a-f0-9]{12}'
        );

        $value = str_replace(['urn:', 'uuid:', '{', '}'], '', (string) $value);

        return !!preg_match($pattern, $value);
    }

    /**
     * Checks if value is a timezone
     */
    public static function isTimezone(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return self::isValidTimezone((string) $value);
    }

    /**
     * Checks if value is a JSON string
     */
    public static function isJson(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        if (((string) $value) === 'null') {
            return true;
        }

        return json_decode((string) $value) !== null
            && json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Checks if value matches a regular expression
     */
    public static function isMatch(mixed $value, string $pattern): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match($pattern, (string) $value);
    }

    /**
     * Checks if value contains a search string
     */
    public static function contains(mixed $value, string $search): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return str_contains((string) $value, $search);
    }

    /**
     * Checks if value starts with a search string
     */
    public static function startsWith(mixed $value, string $search): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return str_starts_with((string) $value, $search);
    }

    /**
     * Checks if value ends with a search string
     */
    public static function endsWith(mixed $value, string $search): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return str_ends_with((string) $value, $search);
    }

    /**
     * Checks if value has an exact string length
     */
    public static function exactLength(
        mixed $value,
        int $length,
        string $encoding = 'UTF-8'
    ): bool {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strLength = (int) mb_strlen((string) $value, $encoding);

        return $strLength === $length;
    }

    /**
     * Checks if value has a string length greater or equal to a minimum
     */
    public static function minLength(
        mixed $value,
        int $minLength,
        string $encoding = 'UTF-8'
    ): bool {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strLength = (int) mb_strlen((string) $value, $encoding);

        return $strLength >= $minLength;
    }

    /**
     * Checks if value has a string length less or equal to a maximum
     */
    public static function maxLength(
        mixed $value,
        int $maxLength,
        string $encoding = 'UTF-8'
    ): bool {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strLength = (int) mb_strlen((string) $value, $encoding);

        return $strLength <= $maxLength;
    }

    /**
     * Checks if value has a string length within a range
     */
    public static function rangeLength(
        mixed $value,
        int $minLength,
        int $maxLength,
        string $encoding = 'UTF-8'
    ): bool {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strLength = (int) mb_strlen((string) $value, $encoding);

        if ($strLength < $minLength) {
            return false;
        }
        if ($strLength > $maxLength) {
            return false;
        }

        return true;
    }

    /**
     * Checks if value matches an exact numeric value
     */
    public static function exactNumber(mixed $value, int|float $number): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value == $number;
    }

    /**
     * Checks if value is greater or equal to a minimum number
     */
    public static function minNumber(mixed $value, int|float $minNumber): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value >= $minNumber;
    }

    /**
     * Checks if value is less or equal to a maximum number
     */
    public static function maxNumber(mixed $value, int|float $maxNumber): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value <= $maxNumber;
    }

    /**
     * Checks if value is within a numeric range
     */
    public static function rangeNumber(
        mixed $value,
        int|float $minNumber,
        int|float $maxNumber
    ): bool {
        if (!is_numeric($value)) {
            return false;
        }

        if ($value < $minNumber) {
            return false;
        }
        if ($value > $maxNumber) {
            return false;
        }

        return true;
    }

    /**
     * Checks if value is a whole number
     *
     * A whole number is any integer value greater or equal to zero.
     */
    public static function wholeNumber(mixed $value): bool
    {
        if (!static::intValue($value)) {
            return false;
        }

        return ((int) $value) >= 0;
    }

    /**
     * Checks if value is a natural number
     *
     * A natural number is any integer value greater than zero.
     */
    public static function naturalNumber(mixed $value): bool
    {
        if (!static::intValue($value)) {
            return false;
        }

        return ((int) $value) > 0;
    }

    /**
     * Checks if value can be cast to an integer without changing value
     *
     * Passing values include integers, integer strings, and floating-point
     * numbers with integer values.
     */
    public static function intValue(mixed $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return strval(intval($value)) == $value;
    }

    /**
     * Checks if value has an exact count
     */
    public static function exactCount(mixed $value, int $count): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) == $count;
    }

    /**
     * Checks if value has a count greater or equal to a minimum
     */
    public static function minCount(mixed $value, int $minCount): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) >= $minCount;
    }

    /**
     * Checks if value has a count less or equal to a maximum
     */
    public static function maxCount(mixed $value, int $maxCount): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) <= $maxCount;
    }

    /**
     * Checks if value has a count within a range
     */
    public static function rangeCount(
        mixed $value,
        int $minCount,
        int $maxCount
    ): bool {
        if (!static::isCountable($value)) {
            return false;
        }

        $count = count($value);

        if ($count < $minCount) {
            return false;
        }
        if ($count > $maxCount) {
            return false;
        }

        return true;
    }

    /**
     * Checks if value is one of a set of choices
     */
    public static function isOneOf(mixed $value, iterable $choices): bool
    {
        foreach ($choices as $choice) {
            if ($value === $choice) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if value is array accessible with a non-null key
     */
    public static function keyIsset(mixed $value, mixed $key): bool
    {
        if (!static::isArrayAccessible($value)) {
            return false;
        }

        return isset($value[$key]);
    }

    /**
     * Checks if value is array accessible with a non-empty key
     */
    public static function keyNotEmpty(mixed $value, mixed $key): bool
    {
        if (!static::isArrayAccessible($value)) {
            return false;
        }

        return isset($value[$key]) && !empty($value[$key]);
    }

    /**
     * Checks if two values are equal
     */
    public static function areEqual(mixed $value1, mixed $value2): bool
    {
        if (
            static::isEquatable($value1)
            && static::areSameType($value1, $value2)
        ) {
            return $value1->equals($value2);
        }

        return $value1 == $value2;
    }

    /**
     * Checks if two values are not equal
     */
    public static function areNotEqual(mixed $value1, mixed $value2): bool
    {
        if (
            static::isEquatable($value1)
            && static::areSameType($value1, $value2)
        ) {
            return !$value1->equals($value2);
        }

        return $value1 != $value2;
    }

    /**
     * Checks if two values are the same
     */
    public static function areSame(mixed $value1, mixed $value2): bool
    {
        return $value1 === $value2;
    }

    /**
     * Checks if two values are not the same
     */
    public static function areNotSame(mixed $value1, mixed $value2): bool
    {
        return $value1 !== $value2;
    }

    /**
     * Checks if two values are the same type
     */
    public static function areSameType(mixed $value1, mixed $value2): bool
    {
        if (!is_object($value1) || !is_object($value2)) {
            return gettype($value1) === gettype($value2);
        }

        return get_class($value1) === get_class($value2);
    }

    /**
     * Checks if value is a given type
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public static function isType(mixed $value, ?string $type): bool
    {
        if ($type === null) {
            return true;
        }

        $result = self::isSimpleType($value, $type);

        if ($result !== null) {
            return $result;
        }

        return ($value instanceof $type);
    }

    /**
     * Checks if value is a list of a given type
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string]
     */
    public static function isListOf(mixed $value, ?string $type): bool
    {
        if (!static::isTraversable($value)) {
            return false;
        }

        if ($type === null) {
            return true;
        }

        $result = true;

        foreach ($value as $val) {
            if (!static::isType($val, $type)) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * Checks if value can be cast to a string
     */
    public static function isStringCastable(mixed $value): bool
    {
        $result = false;
        $type = strtolower(gettype($value));
        switch ($type) {
            case 'string':
            case 'null':
            case 'boolean':
            case 'integer':
            case 'double':
                $result = true;
                break;
            case 'object':
                if ($value instanceof Stringable) {
                    $result = true;
                }
                break;
            default:
                break;
        }

        return $result;
    }

    /**
     * Checks if value can be JSON encoded
     */
    public static function isJsonEncodable(mixed $value): bool
    {
        $result = @json_encode($value);

        if (!is_string($result)) {
            return false;
        }

        return true;
    }

    /**
     * Checks if value is traversable
     */
    public static function isTraversable(mixed $value): bool
    {
        if (is_array($value)) {
            return true;
        }

        if (is_object($value) && ($value instanceof Traversable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is countable
     */
    public static function isCountable(mixed $value): bool
    {
        if (is_array($value)) {
            return true;
        }

        if (is_object($value) && ($value instanceof Countable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is array accessible
     */
    public static function isArrayAccessible(mixed $value): bool
    {
        if (is_array($value)) {
            return true;
        }

        if (is_object($value) && ($value instanceof ArrayAccess)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is a comparable object
     */
    public static function isComparable(mixed $value): bool
    {
        if (is_object($value) && ($value instanceof Comparable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is an equatable object
     */
    public static function isEquatable(mixed $value): bool
    {
        if (is_object($value) && ($value instanceof Equatable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value implements a given interface
     */
    public static function implementsInterface(
        mixed $value,
        string $interface
    ): bool {
        if (!is_object($value)) {
            $exists = static::classExists($value)
                || static::interfaceExists($value);
            if (!$exists) {
                return false;
            }
            $value = (string) $value;
        }

        $reflection = new ReflectionClass($value);

        return $reflection->implementsInterface($interface);
    }

    /**
     * Checks if value is an instance of a type
     */
    public static function isInstanceOf(mixed $value, string $className): bool
    {
        return ($value instanceof $className);
    }

    /**
     * Checks if value is an object or class with a given parent class
     */
    public static function isSubclassOf(mixed $value, string $className): bool
    {
        return is_subclass_of($value, $className);
    }

    /**
     * Checks if value is an existing fully qualified class name
     */
    public static function classExists(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return class_exists((string) $value);
    }

    /**
     * Checks if value is an existing fully qualified interface name
     */
    public static function interfaceExists(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return interface_exists((string) $value);
    }

    /**
     * Checks if value is a method name for an object or class
     */
    public static function methodExists(
        mixed $value,
        object|string $object
    ): bool {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return method_exists($object, (string) $value);
    }

    /**
     * Checks if value is an existing file or directory path
     */
    public static function isPath(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return file_exists((string) $value);
    }

    /**
     * Checks if value is an existing file
     */
    public static function isFile(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_file((string) $value);
    }

    /**
     * Checks if value is an existing directory
     */
    public static function isDir(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_dir((string) $value);
    }

    /**
     * Checks if value is a readable file or directory
     */
    public static function isReadable(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_readable((string) $value);
    }

    /**
     * Checks if value is a writable file or directory
     */
    public static function isWritable(mixed $value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_writable((string) $value);
    }

    /**
     * Checks if a timezone string is valid
     */
    private static function isValidTimezone(string $timezone): bool
    {
        // @codeCoverageIgnoreStart
        if (self::$timezones === null) {
            self::$timezones = [];
            foreach (timezone_identifiers_list() as $zone) {
                self::$timezones[$zone] = true;
            }
        }
        // @codeCoverageIgnoreEnd

        return isset(self::$timezones[$timezone]);
    }

    /**
     * Retrieves URI components from regex matches
     */
    private static function uriComponentsFromMatches(array $matches): array
    {
        if (isset($matches[2]) && $matches[2]) {
            $scheme = $matches[1] ?? '';
        } else {
            $scheme = null;
        }
        if (isset($matches[3]) && $matches[3]) {
            $authority = $matches[4] ?? '';
        } else {
            $authority = null;
        }
        $path = $matches[5] ?? '';
        if (isset($matches[6]) && $matches[6]) {
            $query = $matches[7] ?? '';
        } else {
            $query = null;
        }
        if (isset($matches[8]) && $matches[8]) {
            $fragment = $matches[9] ?? '';
        } else {
            $fragment = null;
        }

        return [
            'scheme'    => $scheme,
            'authority' => $authority,
            'path'      => $path,
            'query'     => $query,
            'fragment'  => $fragment
        ];
    }

    /**
     * Checks if URI components are valid
     */
    private static function isValidUri(array $uri): bool
    {
        if (!self::isValidUriScheme($uri['scheme'])) {
            return false;
        }
        if (!self::isValidUriPath($uri['path'])) {
            return false;
        }
        if (!self::isValidUriQuery($uri['query'])) {
            return false;
        }
        if (!self::isValidUriFragment($uri['fragment'])) {
            return false;
        }
        if (!self::isValidUriAuthority($uri['authority'])) {
            return false;
        }

        return true;
    }

    /**
     * Checks if a URI scheme is valid
     */
    private static function isValidUriScheme(?string $scheme): bool
    {
        // http://tools.ietf.org/html/rfc3986#section-3
        // The scheme and path components are required, though the path may be
        // empty (no characters)
        if ($scheme === null || $scheme === '') {
            return false;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.1
        // scheme = ALPHA *( ALPHA / DIGIT / "+" / "-" / "." )
        $pattern = '/\A[a-z][a-z0-9+.\-]*\z/i';

        return !!preg_match($pattern, $scheme);
    }

    /**
     * Checks if a URI authority is valid
     */
    private static function isValidUriAuthority(?string $authority): bool
    {
        if ($authority === null || $authority === '') {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.2
        // authority = [ userinfo "@" ] host [ ":" port ]
        $pattern = '/\A(?:([^@]*)@)?(\[[^\]]*\]|[^:]*)(?::(?:\d*))?\z/';
        preg_match($pattern, $authority, $matches);

        $isValidAuthUser = self::isValidAuthUser(
            (isset($matches[1]) && $matches[1]) ? $matches[1] : null
        );
        $isValidAuthHost = self::isValidAuthHost(
            (isset($matches[2]) && $matches[2]) ? $matches[2] : ''
        );

        if (!$isValidAuthUser) {
            return false;
        }
        if (!$isValidAuthHost) {
            return false;
        }

        return true;
    }

    /**
     * Checks if a URI path is valid
     */
    private static function isValidUriPath(string $path): bool
    {
        // http://tools.ietf.org/html/rfc3986#section-3
        // The scheme and path components are required, though the path may be
        // empty (no characters)
        if ($path === '') {
            return true;
        }

        // path          = path-abempty    ; begins with "/" or is empty
        //               / path-absolute   ; begins with "/" but not "//"
        //               / path-noscheme   ; begins with a non-colon segment
        //               / path-rootless   ; begins with a segment
        //               / path-empty      ; zero characters
        //
        // path-abempty  = *( "/" segment )
        // path-absolute = "/" [ segment-nz *( "/" segment ) ]
        // path-noscheme = segment-nz-nc *( "/" segment )
        // path-rootless = segment-nz *( "/" segment )
        // path-empty    = 0<pchar>
        // segment       = *pchar
        // segment-nz    = 1*pchar
        // segment-nz-nc = 1*( unreserved / pct-encoded / sub-delims / "@" )
        //               ; non-zero-length segment without any colon ":"
        // pchar         = unreserved / pct-encoded / sub-delims / ":" / "@"
        $pattern = sprintf(
            '/\A(?:(?:[%s%s:@]|(?:%s))*\/?)*\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;=',
            '%[a-f0-9]{2}'
        );

        return !!preg_match($pattern, $path);
    }

    /**
     * Checks if a URI query is valid
     */
    private static function isValidUriQuery(?string $query): bool
    {
        if ($query === null || $query === '') {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.4
        // query = *( pchar / "/" / "?" )
        // pchar = unreserved / pct-encoded / sub-delims / ":" / "@"
        $pattern = sprintf(
            '/\A(?:[%s%s\/?:@]|(?:%s))*\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;=',
            '%[a-f0-9]{2}'
        );

        return !!preg_match($pattern, $query);
    }

    /**
     * Checks if a URI fragment is valid
     */
    private static function isValidUriFragment(?string $fragment): bool
    {
        if ($fragment === null || $fragment === '') {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.5
        // fragment = *( pchar / "/" / "?" )
        // pchar = unreserved / pct-encoded / sub-delims / ":" / "@"
        $pattern = sprintf(
            '/\A(?:[%s%s\/?:@]|(?:%s))*\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;=',
            '%[a-f0-9]{2}'
        );

        return !!preg_match($pattern, $fragment);
    }

    /**
     * Checks if authority userinfo is valid
     */
    private static function isValidAuthUser(?string $userinfo): bool
    {
        if ($userinfo === null) {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.2.1
        // userinfo = *( unreserved / pct-encoded / sub-delims / ":" )
        $pattern = sprintf(
            '/\A(?:[%s%s:]|(?:%s))*\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;=',
            '%[a-f0-9]{2}'
        );

        return !!preg_match($pattern, $userinfo);
    }

    /**
     * Checks if authority host is valid
     */
    private static function isValidAuthHost(string $host): bool
    {
        if ($host === '') {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.2.2
        // A host identified by an Internet Protocol literal address, version 6
        // [RFC3513] or later, is distinguished by enclosing the IP literal
        // within square brackets ("[" and "]").  This is the only place where
        // square bracket characters are allowed in the URI syntax.
        if (str_contains($host, '[')) {
            return self::isValidIpLiteral($host);
        }

        // IPv4address = dec-octet "." dec-octet "." dec-octet "." dec-octet
        $dec = '(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])';
        $ipV4 = sprintf('/\A(?:%s\.){3}%s\z/', $dec, $dec);
        if (preg_match($ipV4, $host)) {
            return true;
        }

        // reg-name = *( unreserved / pct-encoded / sub-delims )
        $pattern = sprintf(
            '/\A(?:[%s%s]|(?:%s))*\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;=',
            '%[a-f0-9]{2}'
        );

        return !!preg_match($pattern, $host);
    }

    /**
     * Checks if host is a valid IP literal
     */
    private static function isValidIpLiteral(string $ip): bool
    {
        // outer brackets
        $length = strlen($ip);
        if ($ip[0] !== '[' || $ip[$length - 1] !== ']') {
            return false;
        }

        // remove brackets
        $ip = substr($ip, 1, $length - 2);

        // starts with "v" (case-insensitive)
        // IPvFuture = "v" 1*HEXDIG "." 1*( unreserved / sub-delims / ":" )
        $pattern = sprintf(
            '/\A[v](?:[a-f0-9]+)\.[%s%s:]+\z/i',
            'a-z0-9\-._~',
            '!$&\'()*+,;='
        );
        if (preg_match($pattern, $ip)) {
            return true;
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Checks if a value matches a simple type
     *
     * Returns null if the type is not supported.
     */
    private static function isSimpleType(mixed $value, string $type): ?bool
    {
        switch ($type) {
            case 'array':
                return static::isArray($value);
            case 'object':
                return static::isObject($value);
            case 'bool':
                return static::isBool($value);
            case 'int':
                return static::isInt($value);
            case 'float':
                return static::isFloat($value);
            case 'string':
                return static::isString($value);
            case 'callable':
                return static::isCallable($value);
            default:
                break;
        }

        return null;
    }
}
