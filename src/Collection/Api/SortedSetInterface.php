<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Traversable;

/**
 * SortedSetInterface is the interface for the sorted set type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface SortedSetInterface extends SortedItemCollectionInterface
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
     * @param SortedSetInterface $other The other set
     *
     * @return SortedSetInterface
     */
    public function difference(SortedSetInterface $other);

    /**
     * Retrieves the intersection
     *
     * Creates a new set that contains items that are found in both the current
     * set and the provided set.
     *
     * A ∩ B = {x : x ∈ A ∧ x ∈ B}
     *
     * @param SortedSetInterface $other The other set
     *
     * @return SortedSetInterface
     */
    public function intersection(SortedSetInterface $other);

    /**
     * Retrieves the relative complement
     *
     * Creates a new set that contains items in the provided set that are not
     * found in the current set.
     *
     * B \ A = {x : x ∈ B ∧ x ∉ A}
     *
     * @param SortedSetInterface $other The other set
     *
     * @return SortedSetInterface
     */
    public function complement(SortedSetInterface $other);

    /**
     * Retrieves the union
     *
     * Creates a new set that contains items found in either the current set or
     * the provided set.
     *
     * A ∪ B = {x : x ∈ A ∨ x ∈ B}
     *
     * @param SortedSetInterface $other The other set
     *
     * @return SortedSetInterface
     */
    public function union(SortedSetInterface $other);

    /**
     * Retrieves an inclusive list of items between given items
     *
     * @param mixed $lo The lower bound
     * @param mixed $hi The upper bound
     *
     * @return Traversable
     */
    public function range($lo, $hi): Traversable;

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
     * Retrieves the minimum item
     *
     * @return mixed
     *
     * @throws UnderflowException When the set is empty
     */
    public function min();

    /**
     * Retrieves the maximum item
     *
     * @return mixed
     *
     * @throws UnderflowException When the set is empty
     */
    public function max();

    /**
     * Removes the minimum item
     *
     * @return void
     *
     * @throws UnderflowException When the set is empty
     */
    public function removeMin(): void;

    /**
     * Removes the maximum item
     *
     * @return void
     *
     * @throws UnderflowException When the set is empty
     */
    public function removeMax(): void;

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
}
