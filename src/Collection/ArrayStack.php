<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Iterator;
use Novuso\System\Collection\Api\Stack;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Test;
use Traversable;

/**
 * ArrayStack is an implementation of the stack type
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayStack implements Arrayable, Stack
{
    use ItemTypeMethods;

    /**
     * Stack items
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
     * Constructs ArrayStack
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
     * @return ArrayStack
     */
    public static function of(string $itemType = null): ArrayStack
    {
        return new self($itemType);
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
    public function push($item)
    {
        assert(
            Test::isType($item, $this->itemType()),
            $this->itemTypeError('push', $item)
        );

        $index = $this->count++;
        $this->items[$index] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Stack underflow');
        }

        $index = $this->count - 1;
        $item = $this->items[$index];
        unset($this->items[$index]);
        $this->count--;

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function top()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Stack underflow');
        }

        $index = $this->count - 1;

        return $this->items[$index];
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
    public function map(callable $callback, string $itemType = null): ArrayStack
    {
        $stack = self::of($itemType);

        for ($i = 0; $i < $this->count; $i++) {
            $stack->push(call_user_func($callback, $this->items[$i]));
        }

        return $stack;
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
    public function filter(callable $predicate): ArrayStack
    {
        $stack = self::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (call_user_func($predicate, $this->items[$i])) {
                $stack->push($this->items[$i]);
            }
        }

        return $stack;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate): ArrayStack
    {
        $stack = self::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (!call_user_func($predicate, $this->items[$i])) {
                $stack->push($this->items[$i]);
            }
        }

        return $stack;
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
        $stack1 = self::of($this->itemType());
        $stack2 = self::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (call_user_func($predicate, $this->items[$i])) {
                $stack1->push($this->items[$i]);
            } else {
                $stack2->push($this->items[$i]);
            }
        }

        return [$stack1, $stack2];
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        /**
         * Iterator
         */
        return new class($this->items) implements Iterator
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
            public function rewind()
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

                return $this->items[$this->index];
            }

            /**
             * Moves the iterator to the next item
             *
             * @return void
             */
            public function next()
            {
                $this->index--;
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $array = $this->items;

        return $array;
    }
}
