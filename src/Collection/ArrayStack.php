<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Api\Stack;
use Novuso\System\Collection\Iterator\ArrayStackIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * ArrayStack is an implementation of the stack type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
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
    public function __construct(?string $itemType = null)
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
    public static function of(?string $itemType = null): ArrayStack
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
    public function push($item): void
    {
        assert(
            Validate::isType($item, $this->itemType()),
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
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $item) {
            call_user_func($callback, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null): ArrayStack
    {
        $stack = static::of($itemType);

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
        $stack = static::of($this->itemType());

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
        $stack = static::of($this->itemType());

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
        $stack1 = static::of($this->itemType());
        $stack2 = static::of($this->itemType());

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
        return new ArrayStackIterator($this->items);
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
