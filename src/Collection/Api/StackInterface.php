<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Novuso\System\Exception\UnderflowException;

/**
 * StackInterface is the interface for the stack type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface StackInterface extends ItemCollectionInterface
{
    /**
     * Adds an item to the top
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function push($item): void;

    /**
     * Removes and returns the top item
     *
     * @return mixed
     *
     * @throws UnderflowException When the stack is empty
     */
    public function pop();

    /**
     * Retrieves the top item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the stack is empty
     */
    public function top();
}
