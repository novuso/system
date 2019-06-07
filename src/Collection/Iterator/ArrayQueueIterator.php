<?php declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Iterator;

/**
 * Class ArrayQueueIterator
 */
final class ArrayQueueIterator implements Iterator
{
    /**
     * Items
     *
     * @var array
     */
    protected $items;

    /**
     * Front index
     *
     * @var int
     */
    protected $front;

    /**
     * Capacity
     *
     * @var int
     */
    protected $cap;

    /**
     * Current index
     *
     * @var int
     */
    protected $index;

    /**
     * Item count
     *
     * @var int
     */
    protected $count;

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
