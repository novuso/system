<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Type\Arrayable;

/**
 * Interface Set
 */
interface Set extends Arrayable, ItemCollection, JsonSerializable
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function union(Set $other);

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
