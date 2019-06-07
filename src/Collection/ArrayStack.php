<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Iterator\ArrayStackIterator;
use Novuso\System\Collection\Mixin\ItemTypeMethods;
use Novuso\System\Collection\Type\Stack;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Utility\Assert;

/**
 * Class ArrayStack
 */
final class ArrayStack implements Stack
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
        Assert::isType($item, $this->itemType());
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
        foreach ($this->getIterator() as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null)
    {
        $stack = static::of($itemType);

        for ($i = 0; $i < $this->count; $i++) {
            $stack->push(call_user_func($callback, $this->items[$i], $i));
        }

        return $stack;
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
        $stack = static::of($this->itemType());

        for ($i = 0; $i < $this->count; $i++) {
            if (call_user_func($predicate, $this->items[$i], $i)) {
                $stack->push($this->items[$i]);
            }
        }

        return $stack;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
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
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayStackIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $array = $this->items;

        return array_reverse($array);
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
