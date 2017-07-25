<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use ArrayAccess;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;

/**
 * ListInterface is the interface for the list type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface ListInterface extends ArrayAccess, ItemCollectionInterface
{
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
     * Sorts the list using a comparator function
     *
     * The comparator should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * Comparator signature:
     *
     * <code>
     * function ($item1, $item2): int {}
     * </code>
     *
     * @param callable $comparator The comparison function
     *
     * @return void
     */
    public function sort(callable $comparator): void;

    /**
     * Retrieves the first value
     *
     * @return mixed
     *
     * @throws UnderflowException When the list is empty
     */
    public function first();

    /**
     * Retrieves the last value
     *
     * @return mixed
     *
     * @throws UnderflowException When the list is empty
     */
    public function last();

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
     * Retrieves an array representation
     *
     * @return array
     */
    public function toArray(): array;
}
