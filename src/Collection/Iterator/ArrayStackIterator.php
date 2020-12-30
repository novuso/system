<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Iterator;

/**
 * Class ArrayStackIterator
 */
final class ArrayStackIterator implements Iterator
{
    protected int $index;
    protected int $count;

    /**
     * Constructs ArrayStackIterator
     *
     * @codeCoverageIgnore coverage bug
     */
    public function __construct(protected array $items)
    {
        $this->count = count($this->items);
        $this->index = $this->count - 1;
    }

    /**
     * Rewinds the iterator
     */
    public function rewind(): void
    {
        $this->index = $this->count - 1;
    }

    /**
     * Checks if the current index is valid
     */
    public function valid(): bool
    {
        return $this->index >= 0;
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

        return $this->items[$this->index];
    }

    /**
     * Moves the iterator to the next item
     */
    public function next(): void
    {
        $this->index--;
    }
}
