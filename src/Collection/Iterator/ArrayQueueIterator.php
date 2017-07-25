<?php declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Iterator;

/**
 * ArrayQueueIterator is the iterator used by an array queue
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayQueueIterator implements Iterator
{
    /**
     * Items
     *
     * @var array
     */
    private $items;

    /**
     * Front index
     *
     * @var int
     */
    private $front;

    /**
     * Capacity
     *
     * @var int
     */
    private $cap;

    /**
     * Current index
     *
     * @var int
     */
    private $index;

    /**
     * Item count
     *
     * @var int
     */
    private $count;

    /**
     * Constructor
     *
     * @param array $items The items
     * @param int   $front The front index
     * @param int   $cap   The capacity
     */
    public function __construct(array $items, int $front, int $cap)
    {
        $this->items = $items;
        $this->front = $front;
        $this->cap = $cap;
        $this->index = 0;
        $this->count = count($this->items);
    }

    /**
     * Rewinds the iterator
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Checks if the current index is valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->index < $this->count;
    }

    /**
     * Retrieves the current key
     *
     * @return int|null
     */
    public function key(): ?int
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->index;
    }

    /**
     * Retrieves the current item
     *
     * @return mixed
     */
    public function current()
    {
        if (!$this->valid()) {
            return null;
        }

        $index = $this->index;
        $front = $this->front;
        $cap = $this->cap;
        $offset = ($index + $front) % $cap;

        return $this->items[$offset];
    }

    /**
     * Moves the iterator to the next item
     *
     * @return void
     */
    public function next(): void
    {
        $this->index++;
    }
}
