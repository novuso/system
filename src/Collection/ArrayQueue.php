<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Iterator;
use Novuso\System\Collection\Api\Queue;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Test;
use Traversable;

/**
 * ArrayQueue is an implementation of the queue type
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayQueue implements Arrayable, Queue
{
    use ItemTypeMethods;

    /**
     * Queue items
     *
     * @var array
     */
    protected $items;

    /**
     * Item count
     *
     * @var int
     */
    protected $count;

    /**
     * Front item index
     *
     * @var int
     */
    protected $front;

    /**
     * Next available index
     *
     * @var int
     */
    protected $end;

    /**
     * Capacity
     *
     * @var int
     */
    protected $cap;

    /**
     * Constructs ArrayQueue
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     */
    public function __construct(string $itemType = null)
    {
        $this->setItemType($itemType);
        $this->items = [];
        $this->count = 0;
        $this->front = 0;
        $this->end = 0;
        $this->cap = 10;
    }

    /**
     * Creates collection of a specific item type
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     *
     * @return ArrayQueue
     */
    public static function of(string $itemType = null): ArrayQueue
    {
        return new static($itemType);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function enqueue($item)
    {
        assert(
            Test::isType($item, $this->itemType()),
            $this->itemTypeError('enqueue', $item)
        );

        if ($this->count === $this->cap) {
            $this->reindex($this->cap * 2);
        }

        $index = $this->end++;
        $this->items[$index] = $item;

        if ($this->end === $this->cap) {
            $this->end = 0;
        }

        $this->count++;
    }

    /**
     * {@inheritdoc}
     */
    public function dequeue()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        $item = $this->items[$this->front];
        unset($this->items[$this->front]);
        $this->count--;
        $this->front++;

        if ($this->front === $this->cap) {
            $this->front = 0;
        }

        if ($this->count > 0 && $this->count === $this->cap / 4) {
            $this->reindex($this->cap / 2);
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function front()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        return $this->items[$this->front];
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callback)
    {
        foreach ($this->getIterator() as $item) {
            call_user_func($callback, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, string $itemType = null): ArrayQueue
    {
        $queue = static::of($itemType);

        foreach ($this->getIterator() as $item) {
            $queue->enqueue(call_user_func($callback, $item));
        }

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function find(callable $predicate)
    {
        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $predicate): ArrayQueue
    {
        $queue = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $queue->enqueue($item);
            }
        }

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate): ArrayQueue
    {
        $queue = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (!call_user_func($predicate, $item)) {
                $queue->enqueue($item);
            }
        }

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function any(callable $predicate): bool
    {
        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function every(callable $predicate): bool
    {
        foreach ($this->getIterator() as $item) {
            if (!call_user_func($predicate, $item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function partition(callable $predicate): array
    {
        $queue1 = static::of($this->itemType());
        $queue2 = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $queue1->enqueue($item);
            } else {
                $queue2->enqueue($item);
            }
        }

        return [$queue1, $queue2];
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        /**
         * Iterator
         */
        return new class($this->items, $this->front, $this->cap) implements Iterator
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
            public function rewind()
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
            public function key()
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
            public function next()
            {
                $this->index++;
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $items = [];

        foreach ($this->getIterator() as $item) {
            $items[] = $item;
        }

        return $items;
    }

    /**
     * Re-indexes the underlying array
     *
     * This is needed to keep wrapping under control. Using direct indices
     * allows operations in constant amortized time instead of O(n).
     *
     * Using array_(un)shift is easier, but requires re-indexing the array
     * every time during the enqueue or dequeue operation.
     *
     * @param int $capacity The new capacity
     *
     * @return void
     */
    private function reindex(int $capacity)
    {
        $temp = [];
        for ($i = 0; $i < $this->count; $i++) {
            $temp[$i] = $this->items[($i + $this->front) % $this->cap];
        }
        $this->items = $temp;
        $this->cap = $capacity;
        $this->front = 0;
        $this->end = $this->count;
    }
}
