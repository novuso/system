<?php declare(strict_types=1);

namespace Novuso\System\Collection\Contract;

use Novuso\System\Type\Comparator;

/**
 * Interface SortedItemCollection
 */
interface SortedItemCollection extends Collection
{
    /**
     * Creates collection with a custom comparator
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $itemType   The item type
     *
     * @return static
     */
    public static function create(Comparator $comparator, ?string $itemType = null);

    /**
     * Creates collection of comparable items
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The item type must be a fully-qualified class name that implements:
     * `Novuso\System\Type\Comparable`
     *
     * @param string|null $itemType The item type
     *
     * @return static
     */
    public static function comparable(?string $itemType = null);

    /**
     * Creates collection of items sorted by callback
     *
     * The callback should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item1, <I> $item2): int {}
     * </code>
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param callable    $callback The sorting callback function
     * @param string|null $itemType The item type
     *
     * @return static
     */
    public static function callback(callable $callback, ?string $itemType = null);

    /**
     * Creates collection of floats
     *
     * @return static
     */
    public static function float();

    /**
     * Creates collection of integers
     *
     * @return static
     */
    public static function integer();

    /**
     * Creates collection of strings
     *
     * @return static
     */
    public static function string();

    /**
     * Retrieves the item type
     *
     * Returns null if the collection type is dynamic.
     *
     * @return string|null
     */
    public function itemType(): ?string;

    /**
     * Applies a callback function to every item
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item, int $index): void {}
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
     * Callback signature:
     *
     * <code>
     * function (<I> $item, int $index): mixed {}
     * </code>
     *
     * @param callable    $callback   The callback
     * @param Comparator  $comparator The comparator
     * @param string|null $itemType   The item type for the new collection
     *
     * @return static
     */
    public function map(callable $callback, Comparator $comparator, ?string $itemType = null);

    /**
     * Retrieves the maximum value in the list
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item, int $index): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback
     *
     * @return mixed
     */
    public function max(?callable $callback = null);

    /**
     * Retrieves the minimum value in the list
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item, int $index): mixed {}
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
     * function ($accumulator, <I> $item, int $index): mixed {}
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
     * function (<I> $item, int $index): int|float {}
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
     * function (<I> $item, int $index): int|float {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return int|float|null
     */
    public function average(?callable $callback = null);

    /**
     * Retrieves the first item that passes a truth test
     *
     * Returns null if no item passes the test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return mixed|null
     */
    public function find(callable $predicate);

    /**
     * Creates a collection from items that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static
     */
    public function filter(callable $predicate);

    /**
     * Creates a collection from items that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static
     */
    public function reject(callable $predicate);

    /**
     * Checks if any items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function any(callable $predicate): bool;

    /**
     * Checks if all items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
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
     * Items that pass the truth test are placed in the first collection.
     *
     * Items that fail the truth test are placed in the second collection.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return static[]
     */
    public function partition(callable $predicate): array;
}
