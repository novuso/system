<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use ArrayAccess;
use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface ItemList
 */
interface ItemList extends Arrayable, ArrayAccess, ItemCollection, JsonSerializable
{
    /**
     * Retrieves the length of the list
     */
    public function length(): int;

    /**
     * Creates a list with the items replaced
     */
    public function replace(iterable $items): static;

    /**
     * Adds an item to the end
     */
    public function add(mixed $item): void;

    /**
     * Replaces an item at an index
     *
     * @throws IndexException When the index is not defined
     */
    public function set(int $index, mixed $item): void;

    /**
     * Retrieves an item by index
     *
     * @throws IndexException When the index is not defined
     */
    public function get(int $index): mixed;

    /**
     * Checks if an index is defined
     */
    public function has(int $index): bool;

    /**
     * Removes an item by index
     */
    public function remove(int $index): void;

    /**
     * Checks if an item is in the list
     */
    public function contains(mixed $item, bool $strict = true): bool;

    /**
     * Creates a list sorted using a comparator function
     *
     * The comparator should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * Comparator signature:
     *
     * <code>
     * function (<I> $item1, <I> $item2): int {}
     * </code>
     */
    public function sort(callable $comparator): static;

    /**
     * Creates a list with the items in reverse order
     */
    public function reverse(): static;

    /**
     * Retrieves the head of the list
     *
     * @throws UnderflowException When the list is empty
     */
    public function head(): mixed;

    /**
     * Retrieves the tail of the list
     *
     * @throws UnderflowException When the list is empty
     */
    public function tail(): static;

    /**
     * Retrieves the first value
     *
     * Optionally retrieves the first value that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     */
    public function first(?callable $predicate = null, mixed $default = null): mixed;

    /**
     * Retrieves the last value
     *
     * Optionally retrieves the last value that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     */
    public function last(?callable $predicate = null, mixed $default = null): mixed;

    /**
     * Retrieves the first index of the given item
     *
     * Optionally retrieves the first index that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param mixed|callable $object The search item or a predicate function
     */
    public function indexOf(mixed $object): ?int;

    /**
     * Retrieves the last index of the given item
     *
     * Optionally retrieves the last index that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function (<I> $item, int $index): bool {}
     * </code>
     *
     * @param mixed|callable $object The search item or a predicate function
     */
    public function lastIndexOf(mixed $object): ?int;

    /**
     * Sets the internal pointer to the first item
     */
    public function rewind(): void;

    /**
     * Sets the internal pointer to the last item
     */
    public function end(): void;

    /**
     * Checks if the internal pointer is at a valid index
     */
    public function valid(): bool;

    /**
     * Moves the internal pointer to the next value
     */
    public function next(): void;

    /**
     * Moves the internal pointer to the previous value
     */
    public function prev(): void;

    /**
     * Retrieves the index of the internal pointer
     *
     * Returns null if the internal pointer points beyond the end of the list
     * or the list is empty.
     */
    public function key(): ?int;

    /**
     * Retrieves the value at the internal pointer
     *
     * Returns null if the internal pointer points beyond the end of the list
     * or the list is empty.
     */
    public function current(): mixed;

    /**
     * Creates a collection with unique items
     *
     * Optional callback should return a string value for equality comparison.
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item, int $index): string {}
     * </code>
     */
    public function unique(?callable $callback = null): static;

    /**
     * Creates a collection from a slice of items
     */
    public function slice(int $index, ?int $length = null): static;

    /**
     * Creates a paginated collection
     */
    public function page(int $page, int $perPage): static;

    /**
     * Retrieves an array representation
     */
    public function toArray(): array;

    /**
     * Retrieves a JSON representation
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string;

    /**
     * Retrieves a representation for JSON encoding
     */
    public function jsonSerialize(): array;

    /**
     * Retrieves a string representation
     */
    public function toString(): string;

    /**
     * Handles casting to a string
     */
    public function __toString(): string;
}
