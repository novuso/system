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
    public function difference(Set $other): static;

    /**
     * Retrieves the intersection
     *
     * Creates a new set that contains items that are found in both the current
     * set and the provided set.
     *
     * A ∩ B = {x : x ∈ A ∧ x ∈ B}
     */
    public function intersection(Set $other): static;

    /**
     * Retrieves the relative complement
     *
     * Creates a new set that contains items in the provided set that are not
     * found in the current set.
     *
     * B \ A = {x : x ∈ B ∧ x ∉ A}
     */
    public function complement(Set $other): static;

    /**
     * Retrieves the union
     *
     * Creates a new set that contains items found in either the current set or
     * the provided set.
     *
     * A ∪ B = {x : x ∈ A ∨ x ∈ B}
     */
    public function union(Set $other): static;

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
