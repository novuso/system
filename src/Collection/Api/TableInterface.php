<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use ArrayAccess;
use Novuso\System\Exception\KeyException;
use Traversable;

/**
 * TableInterface is the interface for the symbol table type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface TableInterface extends ArrayAccess, KeyValueCollectionInterface
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
     * @return Traversable
     */
    public function keys(): Traversable;
}
