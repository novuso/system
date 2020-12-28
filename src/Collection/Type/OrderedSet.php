<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\OrderedItemCollection;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface OrderedSet
 */
interface OrderedSet extends Arrayable, OrderedItemCollection, JsonSerializable
{
    /**
     * Adds an item
     */
    public function add(mixed $item): void;

    /**
     * Checks if an item is in the set
     */
    public function contains(mixed $item): bool;

    /**
     * Removes an item
     */
    public function remove(mixed $item): void;

    /**
     * Retrieves the symmetric difference
     *
     * Creates a new set that contains items in the current set that are not in
     * the provided set, as well as items in the provided set that are not in
     * the current set.
     *
     * A ∆ B = {x : (x ∈ A) ⊕ (x ∈ B)}
     */
    public function difference(OrderedSet $other): static;

    /**
     * Retrieves the intersection
     *
     * Creates a new set that contains items that are found in both the current
     * set and the provided set.
     *
     * A ∩ B = {x : x ∈ A ∧ x ∈ B}
     */
    public function intersection(OrderedSet $other): static;

    /**
     * Retrieves the relative complement
     *
     * Creates a new set that contains items in the provided set that are not
     * found in the current set.
     *
     * B \ A = {x : x ∈ B ∧ x ∉ A}
     */
    public function complement(OrderedSet $other): static;

    /**
     * Retrieves the union
     *
     * Creates a new set that contains items found in either the current set or
     * the provided set.
     *
     * A ∪ B = {x : x ∈ A ∨ x ∈ B}
     */
    public function union(OrderedSet $other): static;

    /**
     * Retrieves an inclusive list of items between given items
     */
    public function range(mixed $lo, mixed $hi): iterable;

    /**
     * Retrieves the inclusive number of items between given items
     */
    public function rangeCount(mixed $lo, mixed $hi): int;

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
     * @throws UnderflowException When the set is empty
     */
    public function removeMax(?callable $callback = null): void;

    /**
     * Retrieves the largest item less or equal to the given item
     *
     * Returns null if there is not an item less or equal to the given item.
     *
     * @throws UnderflowException When the set is empty
     */
    public function floor(mixed $item): mixed;

    /**
     * Retrieves the smallest item greater or equal to the given item
     *
     * Returns null if there is not a item greater or equal to the given item.
     *
     * @throws UnderflowException When the set is empty
     */
    public function ceiling(mixed $item): mixed;

    /**
     * Retrieves the rank of the given item
     */
    public function rank(mixed $item): int;

    /**
     * Retrieves the item with the given rank
     *
     * @throws LookupException When the rank is not valid
     */
    public function select(int $rank): mixed;

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
