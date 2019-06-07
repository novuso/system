<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\SortedItemCollection;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface OrderedSet
 */
interface OrderedSet extends Arrayable, SortedItemCollection, JsonSerializable
{
    /**
     * Adds an item
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function add($item): void;

    /**
     * Checks if an item is in the set
     *
     * @param mixed $item The item
     *
     * @return bool
     */
    public function contains($item): bool;

    /**
     * Removes an item
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function remove($item): void;

    /**
     * Retrieves the symmetric difference
     *
     * Creates a new set that contains items in the current set that are not in
     * the provided set, as well as items in the provided set that are not in
     * the current set.
     *
     * A ∆ B = {x : (x ∈ A) ⊕ (x ∈ B)}
     *
     * @param OrderedSet $other The other set
     *
     * @return static
     */
    public function difference(OrderedSet $other);

    /**
     * Retrieves the intersection
     *
     * Creates a new set that contains items that are found in both the current
     * set and the provided set.
     *
     * A ∩ B = {x : x ∈ A ∧ x ∈ B}
     *
     * @param OrderedSet $other The other set
     *
     * @return static
     */
    public function intersection(OrderedSet $other);

    /**
     * Retrieves the relative complement
     *
     * Creates a new set that contains items in the provided set that are not
     * found in the current set.
     *
     * B \ A = {x : x ∈ B ∧ x ∉ A}
     *
     * @param OrderedSet $other The other set
     *
     * @return static
     */
    public function complement(OrderedSet $other);

    /**
     * Retrieves the union
     *
     * Creates a new set that contains items found in either the current set or
     * the provided set.
     *
     * A ∪ B = {x : x ∈ A ∨ x ∈ B}
     *
     * @param OrderedSet $other The other set
     *
     * @return static
     */
    public function union(OrderedSet $other);

    /**
     * Retrieves an inclusive list of items between given items
     *
     * @param mixed $lo The lower bound
     * @param mixed $hi The upper bound
     *
     * @return iterable
     */
    public function range($lo, $hi): iterable;

    /**
     * Retrieves the inclusive number of items between given items
     *
     * @param mixed $lo The lower bound
     * @param mixed $hi The upper bound
     *
     * @return int
     */
    public function rangeCount($lo, $hi): int;

    /**
     * Removes the minimum item
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
     * @return void
     *
     * @throws UnderflowException When the set is empty
     */
    public function removeMin(?callable $callback = null): void;

    /**
     * Removes the maximum item
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
     * @return void
     *
     * @throws UnderflowException When the set is empty
     */
    public function removeMax(?callable $callback = null): void;

    /**
     * Retrieves the largest item less or equal to the given item
     *
     * Returns null if there is not an item less or equal to the given item.
     *
     * @param mixed $item The item
     *
     * @return mixed|null
     *
     * @throws UnderflowException When the set is empty
     */
    public function floor($item);

    /**
     * Retrieves the smallest item greater or equal to the given item
     *
     * Returns null if there is not a item greater or equal to the given item.
     *
     * @param mixed $item The item
     *
     * @return mixed|null
     *
     * @throws UnderflowException When the set is empty
     */
    public function ceiling($item);

    /**
     * Retrieves the rank of the given item
     *
     * @param mixed $item The item
     *
     * @return int
     */
    public function rank($item): int;

    /**
     * Retrieves the item with the given rank
     *
     * @param int $rank The rank
     *
     * @return mixed
     *
     * @throws LookupException When the rank is not valid
     */
    public function select(int $rank);

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
