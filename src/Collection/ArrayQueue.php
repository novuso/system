<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Iterator\ArrayQueueIterator;
use Novuso\System\Collection\Mixin\ItemTypeMethods;
use Novuso\System\Collection\Type\Queue;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;

/**
 * Class ArrayQueue
 */
final class ArrayQueue implements Queue
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
    public function __construct(?string $itemType = null)
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
    public static function of(?string $itemType = null): ArrayQueue
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
    public function enqueue($item): void
    {
        Assert::isType($item, $this->itemType());

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
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null)
    {
        $queue = static::of($itemType);

        foreach ($this->getIterator() as $index => $item) {
            $queue->enqueue(call_user_func($callback, $item, $index));
        }

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function max(?callable $callback = null)
    {
        if ($callback !== null) {
            $maxItem = null;
            $max = null;

            foreach ($this->getIterator() as $index => $item) {
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

            foreach ($this->getIterator() as $index => $item) {
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

        foreach ($this->getIterator() as $index => $item) {
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
        foreach ($this->getIterator() as $index => $item) {
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
        $queue = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $queue->enqueue($item);
            }
        }

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
    {
        $queue = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
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
        foreach ($this->getIterator() as $index => $item) {
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
        foreach ($this->getIterator() as $index => $item) {
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
        $queue1 = static::of($this->itemType());
        $queue2 = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
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
    public function getIterator()
    {
        return new ArrayQueueIterator($this->items, $this->front, $this->cap);
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
    private function reindex(int $capacity): void
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
