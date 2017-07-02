<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Novuso\System\Type\Comparator;

/**
 * OrderedKeyCollection is the interface for ordered key/value collections
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface OrderedKeyCollection extends Collection
{
    /**
     * Creates collection with a custom comparator
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $keyType    The key type
     * @param string|null $valueType  The value type
     *
     * @return OrderedKeyCollection
     */
    public static function create(Comparator $comparator, ?string $keyType = null, ?string $valueType = null);

    /**
     * Creates collection with comparable keys
     *
     * If types are not provided, the types are dynamic.
     *
     * The key type must be a fully-qualified class name that implements:
     * `Novuso\System\Type\Comparable`
     *
     * The value type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     *
     * @return OrderedKeyCollection
     */
    public static function comparable(?string $keyType = null, ?string $valueType = null);

    /**
     * Creates collection with float keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return OrderedKeyCollection
     */
    public static function float(?string $valueType = null);

    /**
     * Creates collection with integer keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return OrderedKeyCollection
     */
    public static function integer(?string $valueType = null);

    /**
     * Creates collection with string keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return OrderedKeyCollection
     */
    public static function string(?string $valueType = null);

    /**
     * Retrieves the key type
     *
     * Returns null if the key type is dynamic.
     *
     * @return string|null
     */
    public function keyType(): ?string;

    /**
     * Retrieves the value type
     *
     * Returns null if the value type is dynamic.
     *
     * @return string|null
     */
    public function valueType(): ?string;

    /**
     * Applies a callback function to every value
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key) {}
     * </code>
     *
     * @param callable $callback The callback
     *
     * @return void
     */
    public function each(callable $callback): void;

    /**
     * Creates a collection from the results of a function
     *
     * Keys are not affected.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): $newValue {}
     * </code>
     *
     * @param callable    $callback  The callback
     * @param string|null $valueType The value type for the new collection
     *
     * @return OrderedKeyCollection
     */
    public function map(callable $callback, ?string $valueType = null);

    /**
     * Retrieves the first key for a value that passes a truth test
     *
     * Returns null if no key-value pair passes the test.
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return mixed|null
     */
    public function find(callable $predicate);

    /**
     * Creates a collection from values that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return OrderedKeyCollection
     */
    public function filter(callable $predicate);

    /**
     * Creates a collection from values that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return OrderedKeyCollection
     */
    public function reject(callable $predicate);

    /**
     * Checks if any values pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function any(callable $predicate): bool;

    /**
     * Checks if all values pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function every(callable $predicate): bool;

    /**
     * Creates two collections based on a truth test
     *
     * Values that pass the truth test are placed in the first collection.
     *
     * Values that fail the truth test are placed in the second collection.
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return OrderedKeyCollection[]
     */
    public function partition(callable $predicate): array;
}
