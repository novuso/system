<?php declare(strict_types=1);

namespace Novuso\System\Utility;

use ArrayAccess;
use Countable;
use DateTimeZone;
use JsonSerializable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use ReflectionClass;
use Serializable;
use Traversable;

/**
 * Test provides static methods for testing values
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class Test
{
    /**
     * Valid timezones
     *
     * @var array
     */
    private static $timezones;

    /**
     * Checks if value is scalar
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isScalar($value): bool
    {
        return is_scalar($value);
    }

    /**
     * Checks if value is a boolean
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isBool($value): bool
    {
        return is_bool($value);
    }

    /**
     * Checks if value is a float
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isFloat($value): bool
    {
        return is_float($value);
    }

    /**
     * Checks if value is an integer
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isInt($value): bool
    {
        return is_int($value);
    }

    /**
     * Checks if value is a string
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isString($value): bool
    {
        return is_string($value);
    }

    /**
     * Checks if value is an array
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isArray($value): bool
    {
        return is_array($value);
    }

    /**
     * Checks if value is an object
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isObject($value): bool
    {
        return is_object($value);
    }

    /**
     * Checks if value is callable
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isCallable($value): bool
    {
        return is_callable($value);
    }

    /**
     * Checks if value is null
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isNull($value): bool
    {
        return $value === null;
    }

    /**
     * Checks if value is not null
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isNotNull($value): bool
    {
        return $value !== null;
    }

    /**
     * Checks if value is true
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isTrue($value): bool
    {
        return $value === true;
    }

    /**
     * Checks if value is false
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isFalse($value): bool
    {
        return $value === false;
    }

    /**
     * Checks if value is empty
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isEmpty($value): bool
    {
        return empty($value);
    }

    /**
     * Checks if value is not empty
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isNotEmpty($value): bool
    {
        return !empty($value);
    }

    /**
     * Checks if value is blank
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isBlank($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return trim((string) $value) === '';
    }

    /**
     * Checks if value is not blank
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isNotBlank($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return trim((string) $value) !== '';
    }

    /**
     * Checks if value is alphabetic
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isAlpha($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z]*\z/ui', (string) $value);
    }

    /**
     * Checks if value is alphanumeric
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isAlnum($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isAlphaDash($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isAlnumDash($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match('/\A[a-z0-9\-_]*\z/ui', (string) $value);
    }

    /**
     * Checks if value contains only digits
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isDigits($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return ctype_digit((string) $value);
    }

    /**
     * Checks if value is numeric
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isNumeric($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_numeric((string) $value);
    }

    /**
     * Checks if value is an email address
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isEmail($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Checks if value is an IP address
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isIpAddress($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Checks if value is an IPv4 address
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isIpV4Address($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * Checks if value is an IPv6 address
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isIpV6Address($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return filter_var((string) $value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Checks if value is a URI
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isUri($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isUrn($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isUuid($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isTimezone($value): bool
    {
        if ($value instanceof DateTimeZone) {
            return true;
        }

        if (!static::isStringCastable($value)) {
            return false;
        }

        return self::isValidTimezone((string) $value);
    }

    /**
     * Checks if value is a JSON string
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isJson($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        if (((string) $value) === 'null') {
            return true;
        }

        return (json_decode((string) $value) !== null && json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Checks if value matches a regular expression
     *
     * @param mixed  $value   The value
     * @param string $pattern The regex pattern
     *
     * @return bool
     */
    public static function isMatch($value, string $pattern): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return !!preg_match($pattern, (string) $value);
    }

    /**
     * Checks if value contains a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return bool
     */
    public static function contains($value, string $search, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return mb_strpos((string) $value, $search, 0, $encoding) !== false;
    }

    /**
     * Checks if value starts with a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return bool
     */
    public static function startsWith($value, string $search, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $searchlen = (int) mb_strlen($search, $encoding);
        $start = mb_substr((string) $value, 0, $searchlen, $encoding);

        return $search === $start;
    }

    /**
     * Checks if value ends with a search string
     *
     * @param mixed  $value    The value
     * @param string $search   The search string
     * @param string $encoding The string encoding
     *
     * @return bool
     */
    public static function endsWith($value, string $search, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $searchlen = (int) mb_strlen($search, $encoding);
        $length = (int) mb_strlen((string) $value, $encoding);
        $end = mb_substr((string) $value, $length - $searchlen, $searchlen, $encoding);

        return $search === $end;
    }

    /**
     * Checks if value has an exact string length
     *
     * @param mixed  $value    The value
     * @param int    $length   The string length
     * @param string $encoding The string encoding
     *
     * @return bool
     */
    public static function exactLength($value, int $length, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strlen = (int) mb_strlen((string) $value, $encoding);

        return $strlen === $length;
    }

    /**
     * Checks if value has a string length greater or equal to a minimum
     *
     * @param mixed  $value     The value
     * @param int    $minLength The minimum length
     * @param string $encoding  The string encoding
     *
     * @return bool
     */
    public static function minLength($value, int $minLength, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strlen = (int) mb_strlen((string) $value, $encoding);

        return $strlen >= $minLength;
    }

    /**
     * Checks if value has a string length less or equal to a maximum
     *
     * @param mixed  $value     The value
     * @param int    $maxLength The maximum length
     * @param string $encoding  The string encoding
     *
     * @return bool
     */
    public static function maxLength($value, int $maxLength, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strlen = (int) mb_strlen((string) $value, $encoding);

        return $strlen <= $maxLength;
    }

    /**
     * Checks if value has a string length within a range
     *
     * @param mixed  $value     The value
     * @param int    $minLength The minimum length
     * @param int    $maxLength The maximum length
     * @param string $encoding  The string encoding
     *
     * @return bool
     */
    public static function rangeLength($value, int $minLength, int $maxLength, string $encoding = 'UTF-8'): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        $strlen = (int) mb_strlen((string) $value, $encoding);

        if ($strlen < $minLength) {
            return false;
        }
        if ($strlen > $maxLength) {
            return false;
        }

        return true;
    }

    /**
     * Checks if value matches an exact numeric value
     *
     * @param mixed     $value  The value
     * @param int|float $number The numeric value
     *
     * @return bool
     */
    public static function exactNumber($value, $number): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value == $number;
    }

    /**
     * Checks if value is greater or equal to a minimum number
     *
     * @param mixed     $value     The value
     * @param int|float $minNumber The minimum number
     *
     * @return bool
     */
    public static function minNumber($value, $minNumber): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value >= $minNumber;
    }

    /**
     * Checks if value is less or equal to a maximum number
     *
     * @param mixed     $value     The value
     * @param int|float $maxNumber The maximum number
     *
     * @return bool
     */
    public static function maxNumber($value, $maxNumber): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value <= $maxNumber;
    }

    /**
     * Checks if value is within a numeric range
     *
     * @param mixed     $value     The value
     * @param int|float $minNumber The minimum number
     * @param int|float $maxNumber The maximum number
     *
     * @return bool
     */
    public static function rangeNumber($value, $minNumber, $maxNumber): bool
    {
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function wholeNumber($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function naturalNumber($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function intValue($value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return strval(intval($value)) == $value;
    }

    /**
     * Checks if value has an exact count
     *
     * @param mixed $value The value
     * @param int   $count The count
     *
     * @return bool
     */
    public static function exactCount($value, int $count): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) == $count;
    }

    /**
     * Checks if value has a count greater or equal to a minimum
     *
     * @param mixed $value    The value
     * @param int   $minCount The minimum count
     *
     * @return bool
     */
    public static function minCount($value, int $minCount): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) >= $minCount;
    }

    /**
     * Checks if value has a count less or equal to a maximum
     *
     * @param mixed $value    The value
     * @param int   $maxCount The maximum count
     *
     * @return bool
     */
    public static function maxCount($value, int $maxCount): bool
    {
        if (!static::isCountable($value)) {
            return false;
        }

        return count($value) <= $maxCount;
    }

    /**
     * Checks if value has a count within a range
     *
     * @param mixed $value    The value
     * @param int   $minCount The minimum count
     * @param int   $maxCount The maximum count
     *
     * @return bool
     */
    public static function rangeCount($value, int $minCount, int $maxCount): bool
    {
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
     *
     * @param mixed             $value   The value
     * @param array|Traversable $choices The choices
     *
     * @return bool
     */
    public static function isOneOf($value, $choices): bool
    {
        assert(
            static::isTraversable($choices),
            sprintf('%s expects $choices to be traversable', __METHOD__)
        );

        foreach ($choices as $choice) {
            if ($value === $choice) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if value is array accessible with a non-null key
     *
     * @param mixed $value The value
     * @param mixed $key   The key
     *
     * @return bool
     */
    public static function keyIsset($value, $key): bool
    {
        if (!static::isArrayAccessible($value)) {
            return false;
        }

        return isset($value[$key]);
    }

    /**
     * Checks if value is array accessible with a non-empty key
     *
     * @param mixed $value The value
     * @param mixed $key   The key
     *
     * @return bool
     */
    public static function keyNotEmpty($value, $key): bool
    {
        if (!static::isArrayAccessible($value)) {
            return false;
        }

        return isset($value[$key]) && !empty($value[$key]);
    }

    /**
     * Checks if two values are equal
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return bool
     */
    public static function areEqual($value1, $value2): bool
    {
        if (static::isEquatable($value1) && static::areSameType($value1, $value2)) {
            return $value1->equals($value2);
        }

        return $value1 == $value2;
    }

    /**
     * Checks if two values are not equal
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return bool
     */
    public static function areNotEqual($value1, $value2): bool
    {
        if (static::isEquatable($value1) && static::areSameType($value1, $value2)) {
            return !$value1->equals($value2);
        }

        return $value1 != $value2;
    }

    /**
     * Checks if two values are the same
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return bool
     */
    public static function areSame($value1, $value2): bool
    {
        return $value1 === $value2;
    }

    /**
     * Checks if two values are not the same
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return bool
     */
    public static function areNotSame($value1, $value2): bool
    {
        return $value1 !== $value2;
    }

    /**
     * Checks if two values are the same type
     *
     * @param mixed $value1 The first value
     * @param mixed $value2 The second value
     *
     * @return bool
     */
    public static function areSameType($value1, $value2): bool
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
     *
     * @param mixed       $value The value
     * @param string|null $type  The type or null to accept all types
     *
     * @return bool
     */
    public static function isType($value, string $type = null): bool
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
     *
     * @param mixed       $value The value
     * @param string|null $type  The type or null to accept all types
     *
     * @return bool
     */
    public static function isListOf($value, string $type = null): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isStringCastable($value): bool
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
                if (method_exists($value, '__toString')) {
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isJsonEncodable($value): bool
    {
        if ($value === null || is_scalar($value) || is_array($value)) {
            return true;
        }

        if (is_object($value) && ($value instanceof JsonSerializable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value can be serialized
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isSerializable($value): bool
    {
        if ($value === null || is_scalar($value) || is_array($value)) {
            return true;
        }

        if (is_object($value) && ($value instanceof Serializable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is traversable
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isTraversable($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isCountable($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isArrayAccessible($value): bool
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
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isComparable($value): bool
    {
        if (is_object($value) && ($value instanceof Comparable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value is an equatable object
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isEquatable($value): bool
    {
        if (is_object($value) && ($value instanceof Equatable)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if value implements a given interface
     *
     * @param mixed  $value     The value
     * @param string $interface The fully qualified interface name
     *
     * @return bool
     */
    public static function implementsInterface($value, string $interface): bool
    {
        if (!is_object($value)) {
            if (!(static::classExists($value) || static::interfaceExists($value))) {
                return false;
            }
            $value = (string) $value;
        }

        $reflection = new ReflectionClass($value);

        return $reflection->implementsInterface($interface);
    }

    /**
     * Checks if value is an instance of a type
     *
     * @param mixed  $value     The value
     * @param string $className The fully qualified class or interface name
     *
     * @return bool
     */
    public static function isInstanceOf($value, string $className): bool
    {
        return ($value instanceof $className);
    }

    /**
     * Checks if value is an object or class with a given parent class
     *
     * @param mixed  $value     The value
     * @param string $className The fully qualified class name
     *
     * @return bool
     */
    public static function isSubclassOf($value, string $className): bool
    {
        return is_subclass_of($value, $className);
    }

    /**
     * Checks if value is an existing fully qualified class name
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function classExists($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return class_exists((string) $value);
    }

    /**
     * Checks if value is an existing fully qualified interface name
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function interfaceExists($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return interface_exists((string) $value);
    }

    /**
     * Checks if value is a method name for an object or class
     *
     * @param mixed         $value  The value
     * @param object|string $object The object or fully qualified class name
     *
     * @return bool
     */
    public static function methodExists($value, $object): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return method_exists($object, (string) $value);
    }

    /**
     * Checks if value is an existing file or directory path
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isPath($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return file_exists((string) $value);
    }

    /**
     * Checks if value is an existing file
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isFile($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_file((string) $value);
    }

    /**
     * Checks if value is an existing directory
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isDir($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_dir((string) $value);
    }

    /**
     * Checks if value is a readable file or directory
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isReadable($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_readable((string) $value);
    }

    /**
     * Checks if value is a writable file or directory
     *
     * @param mixed $value The value
     *
     * @return bool
     */
    public static function isWritable($value): bool
    {
        if (!static::isStringCastable($value)) {
            return false;
        }

        return is_writable((string) $value);
    }

    /**
     * Checks if a timezone string is valid
     *
     * @param string $timezone The timezone string
     *
     * @return bool
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
     *
     * @SuppressWarnings(PHPMD)
     *
     * @param array $matches The regex matches
     *
     * @return array
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
     *
     * @param array $uri an associated array of URI components
     *
     * @return bool
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
     *
     * @param string|null $scheme The URI scheme
     *
     * @return bool
     */
    private static function isValidUriScheme(string $scheme = null): bool
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
     *
     * @param string|null $authority The URI authority
     *
     * @return bool
     */
    private static function isValidUriAuthority(string $authority = null): bool
    {
        if ($authority === null || $authority === '') {
            return true;
        }

        // http://tools.ietf.org/html/rfc3986#section-3.2
        // authority = [ userinfo "@" ] host [ ":" port ]
        $pattern = '/\A(?:([^@]*)@)?(\[[^\]]*\]|[^:]*)(?::(?:\d*))?\z/';
        preg_match($pattern, $authority, $matches);

        if (!self::isValidAuthUser((isset($matches[1]) && $matches[1]) ? $matches[1] : null)) {
            return false;
        }
        if (!self::isValidAuthHost((isset($matches[2]) && $matches[2]) ? $matches[2] : '')) {
            return false;
        }

        return true;
    }

    /**
     * Checks if a URI path is valid
     *
     * @param string $path The URI path
     *
     * @return bool
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
     *
     * @param string|null $query The URI query
     *
     * @return bool
     */
    private static function isValidUriQuery(string $query = null): bool
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
     *
     * @param string|null $fragment The URI fragment
     *
     * @return bool
     */
    private static function isValidUriFragment(string $fragment = null): bool
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
     *
     * @param string|null $userinfo The userinfo
     *
     * @return bool
     */
    private static function isValidAuthUser(string $userinfo = null): bool
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
     *
     * @param string $host The host
     *
     * @return bool
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
        if (strpos($host, '[') !== false) {
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
     *
     * @param string $ip The IP address
     *
     * @return bool
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
     * Returns null if the type is not supported
     *
     * @param mixed  $value The value
     * @param string $type  The type
     *
     * @return bool|null
     */
    private static function isSimpleType($value, string $type)
    {
        switch ($type) {
            case 'array':
                return static::isArray($value);
                break;
            case 'object':
                return static::isObject($value);
                break;
            case 'bool':
                return static::isBool($value);
                break;
            case 'int':
                return static::isInt($value);
                break;
            case 'float':
                return static::isFloat($value);
                break;
            case 'string':
                return static::isString($value);
                break;
            case 'callable':
                return static::isCallable($value);
                break;
            default:
                break;
        }

        return null;
    }
}
