<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

/**
 * Set is the interface for the set type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface Set extends ItemCollection
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
     * @param Set $other The other set
     *
     * @return Set
     */
    public function difference(Set $other);

    /**
     * Retrieves the intersection
     *
     * Creates a new set that contains items that are found in both the current
     * set and the provided set.
     *
     * A ∩ B = {x : x ∈ A ∧ x ∈ B}
     *
     * @param Set $other The other set
     *
     * @return Set
     */
    public function intersection(Set $other);

    /**
     * Retrieves the relative complement
     *
     * Creates a new set that contains items in the provided set that are not
     * found in the current set.
     *
     * B \ A = {x : x ∈ B ∧ x ∉ A}
     *
     * @param Set $other The other set
     *
     * @return Set
     */
    public function complement(Set $other);

    /**
     * Retrieves the union
     *
     * Creates a new set that contains items found in either the current set or
     * the provided set.
     *
     * A ∪ B = {x : x ∈ A ∨ x ∈ B}
     *
     * @param Set $other The other set
     *
     * @return Set
     */
    public function union(Set $other);
}
