<?php declare(strict_types=1);

namespace Novuso\System\Collection\Tree;

use Countable;
use Novuso\System\Exception\KeyException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;

/**
 * Interface BinarySearchTree
 */
interface BinarySearchTree extends Countable
{
    /**
     * Checks if empty
     */
    public function isEmpty(): bool;

    /**
     * Sets a key/value pair
     */
    public function set(mixed $key, mixed $value): void;

    /**
     * Retrieves a value by key
     *
     * @throws KeyException When the key is not defined
     */
    public function get(mixed $key): mixed;

    /**
     * Checks if a key is defined
     */
    public function has(mixed $key): bool;

    /**
     * Removes a key-value pair by key
     */
    public function remove(mixed $key): void;

    /**
     * Retrieves an iterator for keys
     */
    public function keys(): iterable;

    /**
     * Retrieves an inclusive list of keys between given keys
     */
    public function rangeKeys(mixed $lo, mixed $hi): iterable;

    /**
     * Retrieves the inclusive number of keys between given keys
     */
    public function rangeCount(mixed $lo, mixed $hi): int;

    /**
     * Retrieves the minimum key
     *
     * @throws UnderflowException When the tree is empty
     */
    public function min(): mixed;

    /**
     * Retrieves the maximum key
     *
     * @throws UnderflowException When the tree is empty
     */
    public function max(): mixed;

    /**
     * Removes the key-value pair with the minimum key
     *
     * @throws UnderflowException When the tree is empty
     */
    public function removeMin(): void;

    /**
     * Removes the key-value pair with the maximum key
     *
     * @throws UnderflowException When the tree is empty
     */
    public function removeMax(): void;

    /**
     * Retrieves the largest key less or equal to the given key
     *
     * Returns null if there is not a key less or equal to the given key.
     *
     * @throws UnderflowException When the tree is empty
     */
    public function floor(mixed $key): mixed;

    /**
     * Retrieves the smallest key greater or equal to the given key
     *
     * Returns null if there is not a key greater or equal to the given key.
     *
     * @throws UnderflowException When the tree is empty
     */
    public function ceiling(mixed $key): mixed;

    /**
     * Retrieves the rank of the given key
     */
    public function rank(mixed $key): int;

    /**
     * Retrieves the key with the given rank
     *
     * @throws LookupException When the rank is not valid
     */
    public function select(int $rank): mixed;
}
