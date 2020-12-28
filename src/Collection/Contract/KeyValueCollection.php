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
     */
    public static function of(?string $keyType = null, ?string $valueType = null): static;

    /**
     * Retrieves the key type
     *
     * Returns null if the key type is dynamic.
     */
    public function keyType(): ?string;

    /**
     * Retrieves the value type
     *
     * Returns null if the value type is dynamic.
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
     */
    public function map(callable $callback, ?string $valueType = null): static;

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
     */
    public function max(?callable $callback = null): mixed;

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
     */
    public function min(?callable $callback = null): mixed;

    /**
     * Reduces the collection to a single value
     *
     * Callback signature:
     *
     * <code>
     * function ($accumulator, <V> $value, <K> $key): mixed {}
     * </code>
     */
    public function reduce(callable $callback, mixed $initial = null): mixed;

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
     */
    public function sum(?callable $callback = null): int|float|null;

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
     */
    public function average(?callable $callback = null): int|float|null;

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
     */
    public function find(callable $predicate): mixed;

    /**
     * Creates a collection from values that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
     * </code>
     */
    public function filter(callable $predicate): static;

    /**
     * Creates a collection from values that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
     * </code>
     */
    public function reject(callable $predicate): static;

    /**
     * Checks if any values pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<V> $value, <K> $key): bool {}
     * </code>
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
     */
    public function partition(callable $predicate): array;
}
