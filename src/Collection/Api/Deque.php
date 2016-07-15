<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Novuso\System\Exception\UnderflowException;

/**
 * Deque is the interface for the deque type
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface Deque extends ItemCollection
{
    /**
     * Adds an item to the front
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function addFirst($item);

    /**
     * Adds an item to the end
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function addLast($item);

    /**
     * Removes and returns the first item
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeFirst();

    /**
     * Removes and returns the last item
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeLast();

    /**
     * Retrieves the first item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function first();

    /**
     * Retrieves the last item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function last();
}
