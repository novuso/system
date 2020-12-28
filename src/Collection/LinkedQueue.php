<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use IteratorIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Type\Queue;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;
use SplDoublyLinkedList;
use Traversable;

/**
 * Class LinkedQueue
 */
final class LinkedQueue implements Queue
{
    use ItemTypeMethods;

    protected SplDoublyLinkedList $list;

    /**
     * Constructs LinkedQueue
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
        $this->list = new SplDoublyLinkedList();
        $mode = SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP;
        $this->list->setIteratorMode($mode);
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
        return $this->list->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * @inheritDoc
     */
    public function enqueue(mixed $item): void
    {
        Assert::isType($item, $this->itemType());

        $this->list->push($item);
    }

    /**
     * @inheritDoc
     */
    public function dequeue(): mixed
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        return $this->list->shift();
    }

    /**
     * @inheritDoc
     */
    public function front(): mixed
    {
        if ($this->list->isEmpty()) {
            throw new UnderflowException('Queue underflow');
        }

        return $this->list->bottom();
    }

    /**
     * @inheritDoc
     */
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * @inheritDoc
     */
    public function map(callable $callback, ?string $itemType = null): static
    {
        $queue = static::of($itemType);

        foreach ($this->getIterator() as $index => $item) {
            $queue->enqueue(call_user_func($callback, $item, $index));
        }

        return $queue;
    }

    /**
     * @inheritDoc
     */
    public function max(?callable $callback = null): mixed
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
     * @inheritDoc
     */
    public function min(?callable $callback = null): mixed
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
     * @inheritDoc
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        $accumulator = $initial;

        foreach ($this->getIterator() as $index => $item) {
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
        foreach ($this->getIterator() as $index => $item) {
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
        $queue = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $queue->enqueue($item);
            }
        }

        return $queue;
    }

    /**
     * @inheritDoc
     */
    public function reject(callable $predicate): static
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new IteratorIterator($this->list);
    }

    /**
     * @inheritDoc
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

    /**
     * Handles deep cloning
     */
    public function __clone(): void
    {
        $list = clone $this->list;
        $this->list = $list;
    }
}
