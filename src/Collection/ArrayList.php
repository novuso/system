<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use ArrayIterator;
use Novuso\System\Collection\Api\ListInterface;
use Novuso\System\Collection\Sort\Merge;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\Validate;
use Novuso\System\Utility\VarPrinter;
use Traversable;

/**
 * ArrayList is an implementation of the list type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayList implements Arrayable, ListInterface
{
    use ItemTypeMethods;

    /**
     * List items
     *
     * @var array
     */
    protected $items;

    /**
     * Constructs ArrayList
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
     * @return ArrayList
     */
    public static function of(?string $itemType = null): ArrayList
    {
        return new static($itemType);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function add($item): void
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('add', $item)
        );

        $this->items[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $index, $item): void
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('set', $item)
        );

        $count = count($this->items);

        if ($index < -$count || $index > $count - 1) {
            $message = sprintf('Index (%d) out of range[%d, %d]', $index, -$count, $count - 1);
            throw new IndexException($message);
        }

        if ($index < 0) {
            $index += $count;
        }

        $this->items[$index] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $index)
    {
        $count = count($this->items);

        if ($index < -$count || $index > $count - 1) {
            $message = sprintf('Index (%d) out of range[%d, %d]', $index, -$count, $count - 1);
            throw new IndexException($message);
        }

        if ($index < 0) {
            $index += $count;
        }

        return $this->items[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function has(int $index): bool
    {
        $count = count($this->items);

        if ($index < -$count || $index > $count - 1) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(int $index): void
    {
        $count = count($this->items);

        if ($index < -$count || $index > $count - 1) {
            return;
        }

        if ($index < 0) {
            $index += $count;
        }

        array_splice($this->items, $index, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($index, $item): void
    {
        if ($index === null) {
            $this->add($item);

            return;
        }

        assert(
            Validate::isInt($index),
            sprintf('Invalid list index: %s', VarPrinter::toString($index))
        );

        $this->set($index, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($index)
    {
        assert(
            Validate::isInt($index),
            sprintf('Invalid list index: %s', VarPrinter::toString($index))
        );

        return $this->get($index);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($index): bool
    {
        assert(
            Validate::isInt($index),
            sprintf('Invalid list index: %s', VarPrinter::toString($index))
        );

        return $this->has($index);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($index): void
    {
        assert(
            Validate::isInt($index),
            sprintf('Invalid list index: %s', VarPrinter::toString($index))
        );

        $this->remove($index);
    }

    /**
     * {@inheritdoc}
     */
    public function sort(callable $comparator): void
    {
        Merge::sort($this->items, $comparator);
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        if (empty($this->items)) {
            throw new UnderflowException('List underflow');
        }

        return $this->items[0];
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        if (empty($this->items)) {
            throw new UnderflowException('List underflow');
        }

        $index = count($this->items) - 1;

        return $this->items[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function end(): void
    {
        end($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        next($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function prev(): void
    {
        prev($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function key(): ?int
    {
        return key($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if (key($this->items) === null) {
            return null;
        }

        return current($this->items);
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
    public function map(callable $callback, ?string $itemType = null): ArrayList
    {
        $list = static::of($itemType);

        foreach ($this->getIterator() as $item) {
            $list->add(call_user_func($callback, $item));
        }

        return $list;
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
    public function filter(callable $predicate): ArrayList
    {
        $list = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $list->add($item);
            }
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate): ArrayList
    {
        $list = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (!call_user_func($predicate, $item)) {
                $list->add($item);
            }
        }

        return $list;
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
        $list1 = static::of($this->itemType());
        $list2 = static::of($this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $list1->add($item);
            } else {
                $list2->add($item);
            }
        }

        return [$list1, $list2];
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
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
