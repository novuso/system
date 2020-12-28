<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use ArrayIterator;
use Closure;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Type\ItemList;
use Novuso\System\Exception\IndexException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;
use Traversable;

/**
 * Class ArrayList
 */
final class ArrayList implements ItemList
{
    use ItemTypeMethods;

    protected array $items = [];

    /**
     * Constructs ArrayList
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public function __construct(?string $itemType = null)
    {
        $this->setItemType($itemType);
    }

    /**
     * @inheritDoc
     */
    public static function of(?string $itemType = null): static
    {
        return new static($itemType);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @inheritDoc
     */
    public function length(): int
    {
        return count($this->items);
    }

    /**
     * @inheritDoc
     */
    public function replace(iterable $items): static
    {
        $list = static::of($this->itemType());

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $item): void
    {
        Assert::isType($item, $this->itemType());
        $this->items[] = $item;
    }

    /**
     * @inheritDoc
     */
    public function set(int $index, mixed $item): void
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
     * @inheritDoc
     */
    public function get(int $index): mixed
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function contains(mixed $item, bool $strict = true): bool
    {
        return in_array($item, $this->items, $strict);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $index, mixed $item): void
    {
        if ($index === null) {
            $this->add($item);

            return;
        }

        Assert::isInt($index);
        $this->set($index, $item);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $index): mixed
    {
        Assert::isInt($index);

        return $this->get($index);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $index): bool
    {
        Assert::isInt($index);

        return $this->has($index);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $index): void
    {
        Assert::isInt($index);
        $this->remove($index);
    }

    /**
     * @inheritDoc
     */
    public function sort(callable $comparator): static
    {
        $list = static::of($this->itemType());
        $items = $this->items;

        usort($items, $comparator);

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function reverse(): static
    {
        $list = static::of($this->itemType());

        for ($this->end(); $this->valid(); $this->prev()) {
            $list->add($this->current());
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function head(): mixed
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('List underflow');
        }

        $key = array_key_first($this->items);

        return $this->items[$key];
    }

    /**
     * @inheritDoc
     */
    public function tail(): static
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
     * @inheritDoc
     */
    public function first(?callable $predicate = null, mixed $default = null): mixed
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
     * @inheritDoc
     */
    public function last(?callable $predicate = null, mixed $default = null): mixed
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
     * @inheritDoc
     */
    public function indexOf(mixed $object): ?int
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
     * @inheritDoc
     */
    public function lastIndexOf(mixed $object): ?int
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
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->items);
    }

    /**
     * @inheritDoc
     */
    public function end(): void
    {
        end($this->items);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        next($this->items);
    }

    /**
     * @inheritDoc
     */
    public function prev(): void
    {
        prev($this->items);
    }

    /**
     * @inheritDoc
     */
    public function key(): ?int
    {
        return key($this->items);
    }

    /**
     * @inheritDoc
     */
    public function current(): mixed
    {
        if (key($this->items) === null) {
            return null;
        }

        return current($this->items);
    }

    /**
     * @inheritDoc
     */
    public function unique(?callable $callback = null): static
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
     * @inheritDoc
     */
    public function slice(int $index, ?int $length = null): static
    {
        $list = static::of($this->itemType());

        $items = array_slice($this->items, $index, $length);

        foreach ($items as $item) {
            $list->add($item);
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function page(int $page, int $perPage): static
    {
        return $this->slice(($page - 1) * $perPage, $perPage);
    }

    /**
     * @inheritDoc
     */
    public function each(callable $callback): void
    {
        foreach ($this->items as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * @inheritDoc
     */
    public function map(callable $callback, ?string $itemType = null): static
    {
        $list = static::of($itemType);

        foreach ($this->items as $index => $item) {
            $list->add(call_user_func($callback, $item, $index));
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function max(?callable $callback = null): mixed
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
     * @inheritDoc
     */
    public function min(?callable $callback = null): mixed
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
     * @inheritDoc
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        $accumulator = $initial;

        foreach ($this->items as $index => $item) {
            $accumulator = call_user_func($callback, $accumulator, $item, $index);
        }

        return $accumulator;
    }

    /**
     * @inheritDoc
     */
    public function sum(?callable $callback = null): int|float|null
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
     * @inheritDoc
     */
    public function average(?callable $callback = null): int|float|null
    {
        if ($this->isEmpty()) {
            return null;
        }

        $count = $this->count();

        return $this->sum($callback) / $count;
    }

    /**
     * @inheritDoc
     */
    public function find(callable $predicate): mixed
    {
        foreach ($this->items as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $predicate): static
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
     * @inheritDoc
     */
    public function reject(callable $predicate): static
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $array = $this->items;

        return $array;
    }

    /**
     * @inheritDoc
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->toJson();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
