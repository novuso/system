<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use ArrayAccess;
use Novuso\System\Collection\Contract\KeyValueCollection;
use Novuso\System\Exception\KeyException;

/**
 * Interface Table
 */
interface Table extends ArrayAccess, KeyValueCollection
{
    /**
     * Sets a key-value pair
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return void
     */
    public function set($key, $value): void;

    /**
     * Retrieves a value by key
     *
     * @param mixed $key The key
     *
     * @return mixed
     *
     * @throws KeyException When the key is not defined
     */
    public function get($key);

    /**
     * Checks if a key is defined
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function has($key): bool;

    /**
     * Removes a value by key
     *
     * @param mixed $key The key
     *
     * @return void
     */
    public function remove($key): void;

    /**
     * Sets a key-value pair
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return void
     */
    public function offsetSet($key, $value): void;

    /**
     * Retrieves a value by key
     *
     * @param mixed $key The key
     *
     * @return mixed
     *
     * @throws KeyException When the key is not defined
     */
    public function offsetGet($key);

    /**
     * Checks if a key is defined
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function offsetExists($key): bool;

    /**
     * Removes a value by key
     *
     * @param mixed $key The key
     *
     * @return void
     */
    public function offsetUnset($key): void;

    /**
     * Retrieves an iterator for keys
     *
     * @return iterable
     */
    public function keys(): iterable;
}
