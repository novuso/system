<?php declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Iterator;

/**
 * Class ArrayQueueIterator
 */
final class ArrayQueueIterator implements Iterator
{
    protected array $items;
    protected int $front;
    protected int $cap;
    protected int $index;
    protected int $count;

    /**
     * Constructs ArrayQueueIterator
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
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Checks if the current index is valid
     */
    public function valid(): bool
    {
        return $this->index < $this->count;
    }

    /**
     * Retrieves the current key
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
     */
    public function current(): mixed
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
     */
    public function next(): void
    {
        $this->index++;
    }
}
