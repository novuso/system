<?php declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Iterator;

/**
 * ArrayStackIterator is the iterator used by an array stack
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayStackIterator implements Iterator
{
    /**
     * Items
     *
     * @var array
     */
    private $items;

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
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        $this->count = count($this->items);
        $this->index = $this->count - 1;
    }

    /**
     * Rewinds the iterator
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->index = $this->count - 1;
    }

    /**
     * Checks if the current index is valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->index >= 0;
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

        return $this->items[$this->index];
    }

    /**
     * Moves the iterator to the next item
     *
     * @return void
     */
    public function next(): void
    {
        $this->index--;
    }
}
