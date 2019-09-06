<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use ArrayIterator;
use Closure;
use Novuso\System\Collection\Mixin\ItemTypeMethods;
use Novuso\System\Collection\Sort\Merge;
use Novuso\System\Collection\Type\Sequence;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;

/**
 * Class ArrayList
 */
final class ArrayList implements Sequence
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
    public function length(): int
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function replace(iterable $items)
    {
        $list = static::of($this->itemType());

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item): void
    {
        Assert::isType($item, $this->itemType());
        $this->items[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $index, $item): void
    {
        Assert::isType($item, $this->itemType());

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
    public function contains($item, bool $strict = true): bool
    {
        return in_array($item, $this->items, $strict);
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

        Assert::isInt($index);
        $this->set($index, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($index)
    {
        Assert::isInt($index);

        return $this->get($index);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($index): bool
    {
        Assert::isInt($index);

        return $this->has($index);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($index): void
    {
        Assert::isInt($index);
        $this->remove($index);
    }

    /**
     * {@inheritdoc}
     */
    public function sort(callable $comparator, bool $stable = false)
    {
        $list = static::of($this->itemType());
        $items = $this->items;

        if ($stable) {
            Merge::sort($items, $comparator);
        } else {
            usort($items, $comparator);
        }

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function reverse()
    {
        $list = static::of($this->itemType());

        for ($this->end(); $this->valid(); $this->prev()) {
            $list->add($this->current());
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function head()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('List underflow');
        }

        return reset($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function tail()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('List underflow');
        }

        $items = $this->items;
        array_shift($items);

        $list = static::of($this->itemType());

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function first(?callable $predicate = null, $default = null)
    {
        if ($predicate === null) {
            if ($this->isEmpty()) {
                return $default;
            }

            $key = array_key_first($this->items);

            return $this->items[$key];
        }

        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return $item;
            }
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function last(?callable $predicate = null, $default = null)
    {
        if ($predicate === null) {
            if ($this->isEmpty()) {
                return $default;
            }

            $key = array_key_last($this->items);

            return $this->items[$key];
        }

        foreach (array_reverse($this->items, true) as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return $item;
            }
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($object): ?int
    {
        if (!($object instanceof Closure)) {
            $key = array_search($object, $this->items, true);

            if ($key === false) {
                return null;
            }

            return $key;
        }

        foreach ($this->items as $index => $item) {
            if (call_user_func($object, $item, $index)) {
                return $index;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function lastIndexOf($object): ?int
    {
        if (!($object instanceof Closure)) {
            $key = array_search($object, array_reverse($this->items, true), true);

            if ($key === false) {
                return null;
            }

            return $key;
        }

        foreach (array_reverse($this->items, true) as $index => $item) {
            if (call_user_func($object, $item, $index)) {
                return $index;
            }
        }

        return null;
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
    public function unique(?callable $callback = null)
    {
        if ($callback === null) {
            $list = static::of($this->itemType());

            $items = array_values(array_unique($this->items, SORT_REGULAR));

            foreach ($items as $item) {
                $list->add($item);
            }

            return $list;
        }

        $set = [];

        return $this->filter(function ($item, $index) use ($callback, &$set) {
            $hash = call_user_func($callback, $item, $index);

            if (isset($set[$hash])) {
                return false;
            }

            $set[$hash] = true;

            return true;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $index, ?int $length = null)
    {
        $list = static::of($this->itemType());

        $items = array_slice($this->items, $index, $length);

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function page(int $page, int $perPage)
    {
        return $this->slice(($page - 1) * $perPage, $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callback): void
    {
        foreach ($this->items as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null)
    {
        $list = static::of($itemType);

        foreach ($this->items as $index => $item) {
            $list->add(call_user_func($callback, $item, $index));
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function max(?callable $callback = null)
    {
        if ($callback !== null) {
            $maxItem = null;
            $max = null;

            foreach ($this->items as $index => $item) {
                $field = call_user_func($callback, $item, $index);
                if ($max === null || $field > $max) {
                    $max = $field;
                    $maxItem = $item;
                }
            }

            return $maxItem;
        }

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item > $accumulator ? $item : $accumulator;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function min(?callable $callback = null)
    {
        if ($callback !== null) {
            $minItem = null;
            $min = null;

            foreach ($this->items as $index => $item) {
                $field = call_user_func($callback, $item, $index);
                if ($min === null || $field < $min) {
                    $min = $field;
                    $minItem = $item;
                }
            }

            return $minItem;
        }

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item < $accumulator ? $item : $accumulator;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        $accumulator = $initial;

        foreach ($this->items as $index => $item) {
            $accumulator = call_user_func($callback, $accumulator, $item, $index);
        }

        return $accumulator;
    }

    /**
     * {@inheritdoc}
     */
    public function sum(?callable $callback = null)
    {
        if ($this->isEmpty()) {
            return null;
        }

        if ($callback === null) {
            $callback = function ($item) {
                return $item;
            };
        }

        return $this->reduce(function ($total, $item, $index) use ($callback) {
            return $total + call_user_func($callback, $item, $index);
        }, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function average(?callable $callback = null)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $count = $this->count();

        return $this->sum($callback) / $count;
    }

    /**
     * {@inheritdoc}
     */
    public function find(callable $predicate)
    {
        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $predicate)
    {
        $list = static::of($this->itemType());

        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $list->add($item);
            }
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
    {
        $list = static::of($this->itemType());

        foreach ($this->items as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
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
        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
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
        foreach ($this->items as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
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

        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
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
    public function getIterator()
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

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->toJson();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
