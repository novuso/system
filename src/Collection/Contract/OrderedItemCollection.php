<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Contract;

use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Comparator;

/**
 * Interface OrderedItemCollection
 */
interface OrderedItemCollection extends Collection
{
    /**
     * Creates collection with a custom comparator
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public static function create(
        Comparator $comparator,
        ?string $itemType = null
    ): static;

    /**
     * Creates collection of comparable items
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The item type must be a fully-qualified class name that implements:
     * `Novuso\System\Type\Comparable`
     */
    public static function comparable(?string $itemType = null): static;

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
     */
    public static function callback(
        callable $callback,
        ?string $itemType = null
    ): static;

    /**
     * Creates collection of floats
     */
    public static function float(): static;

    /**
     * Creates collection of integers
     */
    public static function integer(): static;

    /**
     * Creates collection of strings
     */
    public static function string(): static;

    /**
     * Retrieves the item type
     *
     * Returns null if the collection type is dynamic.
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
     */
    public function map(
        callable $callback,
        Comparator $comparator,
        ?string $itemType = null
    ): static;

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
     * @throws UnderflowException When the collection is empty
     */
    public function max(?callable $callback = null): mixed;

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
     * @throws UnderflowException When the collection is empty
     */
    public function min(?callable $callback = null): mixed;

    /**
     * Reduces the collection to a single value
     *
     * Callback signature:
     *
     * <code>
     * function ($accumulator, <I> $item, int $index): mixed {}
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
     * function (<I> $item, int $index): int|float {}
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
     * function (<I> $item, int $index): int|float {}
     * </code>
     */
    public function average(?callable $callback = null): int|float|null;

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
     */
    public function find(callable $predicate): mixed;

    /**
     * Creates a collection from items that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     */
    public function filter(callable $predicate): static;

    /**
     * Creates a collection from items that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     */
    public function reject(callable $predicate): static;

    /**
     * Checks if any items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
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
     */
    public function partition(callable $predicate): array;
}
