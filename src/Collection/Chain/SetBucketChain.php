<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

use Countable;
use Novuso\System\Utility\Validate;

/**
 * Class SetBucketChain
 */
final class SetBucketChain implements Countable
{
    protected TerminalBucket $head;
    protected TerminalBucket $tail;
    protected Bucket $current;
    protected int $count;
    protected int $offset;

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
     */
    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * Retrieves the count
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Adds an item
     *
     * Returns true if item added; false if replaced.
     */
    public function add(mixed $item): bool
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
     */
    public function contains(mixed $item): bool
    {
        return $this->locate($item) !== null;
    }

    /**
     * Removes an item
     *
     * Returns true if item removed; false otherwise.
     */
    public function remove(mixed $item): bool
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
     */
    public function rewind(): void
    {
        $this->current = $this->head->next();
        $this->offset = 0;
    }

    /**
     * Sets the pointer to the last bucket
     */
    public function end(): void
    {
        $this->current = $this->tail->prev();
        $this->offset = $this->count - 1;
    }

    /**
     * Checks if the pointer is at a valid offset
     */
    public function valid(): bool
    {
        return !($this->current instanceof TerminalBucket);
    }

    /**
     * Moves the pointer to the next bucket
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
     */
    public function current(): mixed
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
     */
    protected function locate(mixed $item): ?ItemBucket
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
     */
    protected function insertBetween(mixed $item, Bucket $prev, Bucket $next): void
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
