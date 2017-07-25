<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use IteratorIterator;
use Novuso\System\Collection\Api\QueueInterface;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Validate;
use SplDoublyLinkedList;
use Traversable;

/**
 * LinkedQueue is an implementation of the queue type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class LinkedQueue implements Arrayable, QueueInterface
{
    use ItemTypeMethods;

    /**
     * Linked list
     *
     * @var SplDoublyLinkedList
     */
    protected $list;

    /**
     * Constructs LinkedQueue
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     */
    public function __construct(?string $itemType = null)
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
     * @return LinkedQueue
     */
    public static function of(?string $itemType = null): LinkedQueue
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
    public function enqueue($item): void
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('enqueue', $item)
        );

        $this->list->push($item);
    }

    /**
     * {@inheritdoc}
     */
    public function dequeue()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        return $this->list->shift();
    }

    /**
     * {@inheritdoc}
     */
    public function front()
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        return $this->list->bottom();
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $item) {
            call_user_func($callback, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null): LinkedQueue
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
    public function filter(callable $predicate): LinkedQueue
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
    public function reject(callable $predicate): LinkedQueue
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
