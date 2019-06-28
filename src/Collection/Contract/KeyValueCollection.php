<?php declare(strict_types=1);

namespace Novuso\System\Collection\Contract;

/**
 * Interface KeyValueCollection
 */
interface KeyValueCollection extends Collection
{
    /**
     * Creates collection with specific key and value types
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     *
     * @return static
     */
    public static function of(?string $keyType = null, ?string $valueType = null);

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
     * function (<V> $value, <K> $key): void {}
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
     * function (<V> $value, <K> $key): mixed {}
     * </code>
     *
     * @param callable    $callback  The callback
     * @param string|null $valueType The value type for the new collection
     *
     * @return static
     */
    public function map(callable $callback, ?string $valueType = null);

    /**
     * Retrieves the key for the maximum value in the collection
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function (<V> $value, <K> $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback
     *
     * @return mixed
     */
    public function max(?callable $callback = null);

    /**
     * Retrieves the key for the minimum value in the collection
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function (<V> $value, <K> $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback
     *
     * @return mixed
     */
    public function min(?callable $callback = null);

    /**
     * Reduces the collection to a single value
     *
     * Callback signature:
     *
     * <code>
     * function ($accumulator, <V> $value, <K> $key): mixed {}
     * </code>
     *
     * @param callable $callback
     * @param mixed    $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null);

    /**
     * Retrieves the sum of the collection
     *
     * The callback should return a value to sum.
     *
     * Callback signature:
     *
     * <code>
     * function (<V> $value, <K> $key): int|float {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return int|float|null
     */
    public function sum(?callable $callback = null);

    /**
     * Retrieves the average of the collection
     *
     * The callback should return a value to sum.
     *
     * Callback signature:
     *
     * <code>
     * function (<V> $value, <K> $key): int|float {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return int|float|null
     */
    public function average(?callable $callback = null);

    /**
     * Retrieves the first key for a value that passes a truth test
     *
     * Returns null if no key-value pair passes the test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
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
     * function (<V> $value, <K> $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static
     */
    public function filter(callable $predicate);

    /**
     * Creates a collection from values that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static
     */
    public function reject(callable $predicate);

    /**
     * Checks if any values pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
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
     * function (<V> $value, <K> $key): bool {}
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
     * function (<V> $value, <K> $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static[]
     */
    public function partition(callable $predicate): array;
}
