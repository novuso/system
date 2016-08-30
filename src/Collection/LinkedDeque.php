<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use IteratorIterator;
use Novuso\System\Collection\Api\Deque;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Validate;
use SplDoublyLinkedList;
use Traversable;

/**
 * LinkedDeque is an implementation of the deque type
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class LinkedDeque implements Arrayable, Deque
{
    use ItemTypeMethods;

    /**
     * Linked list
     *
     * @var SplDoublyLinkedList
     */
    protected $list;

    /**
     * Constructs LinkedDeque
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
        $this->list = new SplDoublyLinkedList();
        $mode = SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP;
        $this->list->setIteratorMode($mode);
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
     * @return LinkedDeque
     */
    public static function of(string $itemType = null): LinkedDeque
    {
        return new static($itemType);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->list->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst($item)
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('addFirst', $item)
        );

        $this->list->unshift($item);
    }

    /**
     * {@inheritdoc}
     */
    public function addLast($item)
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('addLast', $item)
        );

        $this->list->push($item);
    }

    /**
     * {@inheritdoc}
     */
    public function removeFirst()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Deque underflow');
        }

        return $this->list->shift();
    }

    /**
     * {@inheritdoc}
     */
    public function removeLast()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Deque underflow');
        }

        return $this->list->pop();
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Deque underflow');
        }

        return $this->list->bottom();
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Deque underflow');
        }

        return $this->list->top();
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
    public function map(callable $callback, string $itemType = null): LinkedDeque
    {
        $deque = static::of($itemType);

        foreach ($this->getIterator() as $item) {
            $deque->addLast(call_user_func($callback, $item));
        }

        return $deque;
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
    public function filter(callable $predicate): LinkedDeque
    {
        $deque = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $deque->addLast($item);
            }
        }

        return $deque;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate): LinkedDeque
    {
        $deque = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (!call_user_func($predicate, $item)) {
                $deque->addLast($item);
            }
        }

        return $deque;
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
        $deque1 = static::of($this->itemType());
        $deque2 = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $deque1->addLast($item);
            } else {
                $deque2->addLast($item);
            }
        }

        return [$deque1, $deque2];
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new IteratorIterator($this->list);
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
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $list = clone $this->list;
        $this->list = $list;
    }
}
