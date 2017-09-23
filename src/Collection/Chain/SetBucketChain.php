<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

use Countable;
use Novuso\System\Utility\Validate;

/**
 * SetBucketChain is list of item buckets supporting set operations
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class SetBucketChain implements Countable
{
    /**
     * Head bucket
     *
     * @var TerminalBucket
     */
    protected $head;

    /**
     * Tail bucket
     *
     * @var TerminalBucket
     */
    protected $tail;

    /**
     * Current bucket
     *
     * @var Bucket
     */
    protected $current;

    /**
     * Bucket count
     *
     * @var int
     */
    protected $count;

    /**
     * Current offset
     *
     * @var int
     */
    protected $offset;

    /**
     * Constructs SetBucketChain
     */
    public function __construct()
    {
        $this->head = new TerminalBucket();
        $this->tail = new TerminalBucket();
        $this->head->setNext($this->tail);
        $this->tail->setPrev($this->head);
        $this->current = $this->head;
        $this->count = 0;
        $this->offset = -1;
    }

    /**
     * Checks if empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * Retrieves the count
     *
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Adds an item
     *
     * Returns true if item added; false if replaced.
     *
     * @param mixed $item The item
     *
     * @return bool
     */
    public function add($item): bool
    {
        $added = true;
        $bucket = $this->locate($item);

        if ($bucket !== null) {
            $this->removeBucket($bucket);
            $this->rewind();
            $added = false;
        }

        $this->insertBetween($item, $this->head, $this->head->next());
        $this->offset = 0;

        return $added;
    }

    /**
     * Checks if an item is contained
     *
     * @param mixed $item The item
     *
     * @return bool
     */
    public function contains($item): bool
    {
        return $this->locate($item) !== null;
    }

    /**
     * Removes an item
     *
     * Returns true if item removed; false otherwise.
     *
     * @param mixed $item The item
     *
     * @return bool
     */
    public function remove($item): bool
    {
        $removed = false;
        $bucket = $this->locate($item);

        if ($bucket !== null) {
            $this->removeBucket($bucket);
            $this->rewind();
            $removed = true;
        }

        return $removed;
    }

    /**
     * Sets the pointer to the first bucket
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->current = $this->head->next();
        $this->offset = 0;
    }

    /**
     * Sets the pointer to the last bucket
     *
     * @return void
     */
    public function end(): void
    {
        $this->current = $this->tail->prev();
        $this->offset = $this->count - 1;
    }

    /**
     * Checks if the pointer is at a valid offset
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !($this->current instanceof TerminalBucket);
    }

    /**
     * Moves the pointer to the next bucket
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->current instanceof TerminalBucket) {
            return;
        }

        $this->current = $this->current->next();
        $this->offset++;
    }

    /**
     * Moves the pointer to the previous bucket
     *
     * @return void
     */
    public function prev(): void
    {
        if ($this->current instanceof TerminalBucket) {
            return;
        }

        $this->current = $this->current->prev();
        $this->offset--;
    }

    /**
     * Retrieves the offset of the current bucket
     *
     * Returns null if the pointer is not at a valid offset.
     *
     * @return int|null
     */
    public function key(): ?int
    {
        if ($this->current instanceof TerminalBucket) {
            return null;
        }

        return $this->offset;
    }

    /**
     * Retrieves the item from the current bucket
     *
     * Returns null if the pointer is not at a valid offset.
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->current instanceof TerminalBucket) {
            return null;
        }

        /** @var ItemBucket $current */
        $current = $this->current;

        return $current->item();
    }

    /**
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $items = [];
        for ($this->rewind(); $this->valid(); $this->next()) {
            $items[] = $this->current();
        }
        $this->head = new TerminalBucket();
        $this->tail = new TerminalBucket();
        $this->head->setNext($this->tail);
        $this->tail->setPrev($this->head);
        $this->current = $this->head;
        $this->count = 0;
        $this->offset = -1;
        $prev = $this->head;
        $next = $this->tail;
        foreach ($items as $item) {
            $this->insertBetween($item, $prev, $next);
            $prev = $this->current;
        }
    }

    /**
     * Locates a bucket by item
     *
     * Returns null if the item is not found.
     *
     * @param mixed $item The item
     *
     * @return ItemBucket|null
     */
    protected function locate($item): ?ItemBucket
    {
        for ($this->rewind(); $this->valid(); $this->next()) {
            /** @var ItemBucket $current */
            $current = $this->current;
            if (Validate::areEqual($item, $current->item())) {
                return $current;
            }
        }

        return null;
    }

    /**
     * Removes a bucket
     *
     * @param Bucket $bucket A Bucket instance
     *
     * @return void
     */
    protected function removeBucket(Bucket $bucket): void
    {
        $next = $bucket->next();
        $prev = $bucket->prev();

        $next->setPrev($prev);
        $prev->setNext($next);

        $this->count--;
    }

    /**
     * Inserts an item between two nodes
     *
     * @param mixed  $item The item
     * @param Bucket $prev The previous bucket
     * @param Bucket $next The next bucket
     *
     * @return void
     */
    protected function insertBetween($item, Bucket $prev, Bucket $next): void
    {
        $bucket = new ItemBucket($item);

        $prev->setNext($bucket);
        $next->setPrev($bucket);

        $bucket->setPrev($prev);
        $bucket->setNext($next);

        $this->current = $bucket;
        $this->count++;
    }
}
