<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Iterator\ArrayStackIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Type\Stack;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;
use Traversable;

/**
 * Class ArrayStack
 */
final class ArrayStack implements Stack
{
    use ItemTypeMethods;

    protected array $items = [];
    protected int $count = 0;

    /**
     * Constructs ArrayStack
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
        return $this->count === 0;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @inheritDoc
     */
    public function push(mixed $item): void
    {
        Assert::isType($item, $this->itemType());
        $index = $this->count++;
        $this->items[$index] = $item;
    }

    /**
     * @inheritDoc
     */
    public function pop(): mixed
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
     * @inheritDoc
     */
    public function top(): mixed
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Stack underflow');
        }

        $index = $this->count - 1;

        return $this->items[$index];
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
        $stack = static::of($itemType);

        for ($i = 0; $i < $this->count; $i++) {
            $stack->push(call_user_func($callback, $this->items[$i], $i));
        }

        return $stack;
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
    public function sum(?callable $callback = null): float|int|null
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
    public function average(?callable $callback = null): float|int|null
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
        $stack = static::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (call_user_func($predicate, $this->items[$i], $i)) {
                $stack->push($this->items[$i]);
            }
        }

        return $stack;
    }

    /**
     * @inheritDoc
     */
    public function reject(callable $predicate): static
    {
        $stack = static::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (!call_user_func($predicate, $this->items[$i], $i)) {
                $stack->push($this->items[$i]);
            }
        }

        return $stack;
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
        $stack1 = static::of($this->itemType());
        $stack2 = static::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (call_user_func($predicate, $this->items[$i], $i)) {
                $stack1->push($this->items[$i]);
            } else {
                $stack2->push($this->items[$i]);
            }
        }

        return [$stack1, $stack2];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayStackIterator($this->items);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $array = $this->items;

        return array_reverse($array);
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
