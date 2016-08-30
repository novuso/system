<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

use Countable;
use Novuso\System\Exception\KeyException;
use Novuso\System\Utility\Validate;
use Novuso\System\Utility\VarPrinter;

/**
 * TableBucketChain is a list of key-value buckets supporting table operations
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class TableBucketChain implements Countable
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
     * Constructs TableBucketChain
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
     * Sets a key-value pair
     *
     * Returns true if pair added; false if replaced.
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return bool
     */
    public function set($key, $value): bool
    {
        $added = true;
        $bucket = $this->locate($key);

        if ($bucket !== null) {
            $this->removeBucket($bucket);
            $this->rewind();
            $added = false;
        }

        $this->insertBetween($key, $value, $this->head, $this->head->next());
        $this->offset = 0;

        return $added;
    }

    /**
     * Retrieves a value by key
     *
     * @param mixed $key The key
     *
     * @return mixed
     *
     * @throws KeyException When the key is not found
     */
    public function get($key)
    {
        $bucket = $this->locate($key);

        if ($bucket === null) {
            $message = sprintf('Key not found: %s', VarPrinter::toString($key));
            throw new KeyException($message);
        }

        return $bucket->value();
    }

    /**
     * Checks if a key is defined
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return $this->locate($key) !== null;
    }

    /**
     * Removes a key-value pair by key
     *
     * Returns true if pair removed; false otherwise.
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function remove($key): bool
    {
        $removed = false;
        $bucket = $this->locate($key);

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
    public function rewind()
    {
        $this->current = $this->head->next();
        $this->offset = 0;
    }

    /**
     * Sets the pointer to the last bucket
     *
     * @return void
     */
    public function end()
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
    public function next()
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
    public function prev()
    {
        if ($this->current instanceof TerminalBucket) {
            return;
        }

        $this->current = $this->current->prev();
        $this->offset--;
    }

    /**
     * Retrieves the key from the current bucket
     *
     * Returns null if the pointer is not at a valid offset.
     *
     * @return mixed
     */
    public function key()
    {
        if ($this->current instanceof TerminalBucket) {
            return null;
        }

        /** @var KeyValueBucket $current */
        $current = $this->current;

        return $current->key();
    }

    /**
     * Retrieves the value from the current bucket
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

        /** @var KeyValueBucket $current */
        $current = $this->current;

        return $current->value();
    }

    /**
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $keys = [];
        $values = [];
        for ($this->rewind(); $this->valid(); $this->next()) {
            $values[] = $this->current();
            $keys[] = $this->key();
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
        for ($i = 0; $i < count($keys); $i++) {
            $this->insertBetween($keys[$i], $values[$i], $prev, $next);
            $prev = $this->current;
        }
    }

    /**
     * Locates a bucket by key
     *
     * Returns null if the key is not found.
     *
     * @param mixed $key The key
     *
     * @return KeyValueBucket|null
     */
    protected function locate($key)
    {
        for ($this->rewind(); $this->valid(); $this->next()) {
            /** @var KeyValueBucket $current */
            $current = $this->current;
            if (Validate::areEqual($key, $current->key())) {
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
    protected function removeBucket(Bucket $bucket)
    {
        $next = $bucket->next();
        $prev = $bucket->prev();

        $next->setPrev($prev);
        $prev->setNext($next);

        $this->count--;
    }

    /**
     * Inserts a key-value pair between two nodes
     *
     * @param mixed  $key   The key
     * @param mixed  $value The value
     * @param Bucket $prev  The previous bucket
     * @param Bucket $next  The next bucket
     *
     * @return void
     */
    protected function insertBetween($key, $value, Bucket $prev, Bucket $next)
    {
        $bucket = new KeyValueBucket($key, $value);

        $prev->setNext($bucket);
        $next->setPrev($bucket);

        $bucket->setPrev($prev);
        $bucket->setNext($next);

        $this->current = $bucket;
        $this->count++;
    }
}
