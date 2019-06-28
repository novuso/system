<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use ArrayAccess;
use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface Sequence
 */
interface Sequence extends Arrayable, ArrayAccess, ItemCollection, JsonSerializable
{
    /**
     * Retrieves the length of the list
     *
     * @return int
     */
    public function length(): int;

    /**
     * Creates a list with the items replaced
     *
     * @param iterable $items A list of items
     *
     * @return static
     */
    public function replace(iterable $items);

    /**
     * Adds an item to the end
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function add($item): void;

    /**
     * Replaces an item at an index
     *
     * @param int   $index The index
     * @param mixed $item  The item
     *
     * @return void
     *
     * @throws IndexException When the index is not defined
     */
    public function set(int $index, $item): void;

    /**
     * Retrieves an item by index
     *
     * @param int $index The index
     *
     * @return mixed
     *
     * @throws IndexException When the index is not defined
     */
    public function get(int $index);

    /**
     * Checks if an index is defined
     *
     * @param int $index The index
     *
     * @return bool
     */
    public function has(int $index): bool;

    /**
     * Removes an item by index
     *
     * @param int $index The index
     *
     * @return void
     */
    public function remove(int $index): void;

    /**
     * Checks if an item is in the list
     *
     * @param mixed $item   The item
     * @param bool  $strict Whether strict-type comparison should be used
     *
     * @return bool
     */
    public function contains($item, bool $strict = true): bool;

    /**
     * Sets or appends an item
     *
     * @param int|null $index The index or null to append
     * @param mixed    $item  The item
     *
     * @return void
     *
     * @throws IndexException When the index is not defined
     */
    public function offsetSet($index, $item): void;

    /**
     * Retrieves an item by index
     *
     * @param int $index The index
     *
     * @return mixed
     *
     * @throws IndexException When the index is not defined
     */
    public function offsetGet($index);

    /**
     * Checks if an index is defined
     *
     * @param int $index The index
     *
     * @return bool
     */
    public function offsetExists($index): bool;

    /**
     * Removes an item by index
     *
     * @param int $index The index
     *
     * @return void
     */
    public function offsetUnset($index): void;

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
     *
     * @param callable $comparator The comparison function
     * @param bool     $stable     Whether to use a stable sorting algorithm
     *
     * @return static
     */
    public function sort(callable $comparator, bool $stable = false);

    /**
     * Creates a list with the items in reverse order
     *
     * @return static
     */
    public function reverse();

    /**
     * Retrieves the head of the list
     *
     * @return mixed
     *
     * @throws UnderflowException When the list is empty
     */
    public function head();

    /**
     * Retrieves the tail of the list
     *
     * @return static
     *
     * @throws UnderflowException When the list is empty
     */
    public function tail();

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
     *
     * @param callable|null $predicate The predicate function
     * @param null          $default   The default return value
     *
     * @return mixed
     */
    public function first(?callable $predicate = null, $default = null);

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
     *
     * @param callable|null $predicate The predicate function
     * @param mixed         $default   The default return value
     *
     * @return mixed
     */
    public function last(?callable $predicate = null, $default = null);

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
     *
     * @return int|null
     */
    public function indexOf($object): ?int;

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
     *
     * @return int|null
     */
    public function lastIndexOf($object): ?int;

    /**
     * Sets the internal pointer to the first item
     *
     * @return void
     */
    public function rewind(): void;

    /**
     * Sets the internal pointer to the last item
     *
     * @return void
     */
    public function end(): void;

    /**
     * Checks if the internal pointer is at a valid index
     *
     * @return bool
     */
    public function valid(): bool;

    /**
     * Moves the internal pointer to the next value
     *
     * @return void
     */
    public function next(): void;

    /**
     * Moves the internal pointer to the previous value
     *
     * @return void
     */
    public function prev(): void;

    /**
     * Retrieves the index of the internal pointer
     *
     * Returns null if the internal pointer points beyond the end of the list
     * or the list is empty.
     *
     * @return int|null
     */
    public function key(): ?int;

    /**
     * Retrieves the value at the internal pointer
     *
     * Returns null if the internal pointer points beyond the end of the list
     * or the list is empty.
     *
     * @return mixed|null
     */
    public function current();

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
     *
     * @param callable|null $callback The callback function
     *
     * @return static
     */
    public function unique(?callable $callback = null);

    /**
     * Creates a collection from a slice of items
     *
     * @param int      $index  The starting index
     * @param int|null $length The length or null for remaining
     *
     * @return static
     */
    public function slice(int $index, ?int $length = null);

    /**
     * Creates a paginated collection
     *
     * @param int $page    The page number
     * @param int $perPage The number of items per page
     *
     * @return static
     */
    public function page(int $page, int $perPage);

    /**
     * Retrieves an array representation
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Retrieves a JSON representation
     *
     * @param int $options Bitmask options for JSON encode
     *
     * @return string
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string;

    /**
     * Retrieves a representation for JSON encoding
     *
     * @return array
     */
    public function jsonSerialize(): array;

    /**
     * Retrieves a string representation
     *
     * @return string
     */
    public function toString(): string;

    /**
     * Handles casting to a string
     *
     * @return string
     */
    public function __toString(): string;
}
