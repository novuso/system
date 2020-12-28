<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Collection\Comparison\FunctionComparator;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Tree\BinarySearchTree;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Collection\Type\OrderedSet;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * Class SortedSet
 */
final class SortedSet implements OrderedSet
{
    use ItemTypeMethods;

    protected BinarySearchTree $tree;
    protected Comparator $comparator;

    /**
     * Constructs SortedSet
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public function __construct(Comparator $comparator, ?string $itemType = null)
    {
        $this->setItemType($itemType);
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
    }

    /**
     * @inheritDoc
     */
    public static function create(Comparator $comparator, ?string $itemType = null): static
    {
        return new static($comparator, $itemType);
    }

    /**
     * @inheritDoc
     */
    public static function comparable(?string $itemType = null): static
    {
        Assert::isTrue(Validate::isNull($itemType) || Validate::implementsInterface($itemType, Comparable::class));

        return new static(new ComparableComparator(), $itemType);
    }

    /**
     * @inheritDoc
     */
    public static function callback(callable $callback, ?string $itemType = null): static
    {
        return new static(new FunctionComparator($callback), $itemType);
    }

    /**
     * @inheritDoc
     */
    public static function float(): static
    {
        return new static(new FloatComparator(), 'float');
    }

    /**
     * @inheritDoc
     */
    public static function integer(): static
    {
        return new static(new IntegerComparator(), 'int');
    }

    /**
     * @inheritDoc
     */
    public static function string(): static
    {
        return new static(new StringComparator(), 'string');
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return $this->tree->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->tree->count();
    }

    /**
     * @inheritDoc
     */
    public function add($item): void
    {
        Assert::isType($item, $this->itemType());
        $this->tree->set($item, true);
    }

    /**
     * @inheritDoc
     */
    public function contains($item): bool
    {
        return $this->tree->has($item);
    }

    /**
     * @inheritDoc
     */
    public function remove($item): void
    {
        $this->tree->remove($item);
    }

    /**
     * @inheritDoc
     */
    public function difference(OrderedSet $other): static
    {
        $difference = static::create($this->comparator, $this->itemType());

        if ($this === $other) {
            return $difference;
        }

        $this->reject([$other, 'contains'])->each([$difference, 'add']);
        $other->reject([$this, 'contains'])->each([$difference, 'add']);

        return $difference;
    }

    /**
     * @inheritDoc
     */
    public function intersection(OrderedSet $other): static
    {
        $intersection = static::create($this->comparator, $this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * @inheritDoc
     */
    public function complement(OrderedSet $other): static
    {
        $complement = static::create($this->comparator, $this->itemType());

        if ($this === $other) {
            return $complement;
        }

        $other->reject([$this, 'contains'])->each([$complement, 'add']);

        return $complement;
    }

    /**
     * @inheritDoc
     */
    public function union(OrderedSet $other): static
    {
        $union = static::create($this->comparator, $this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
    }

    /**
     * @inheritDoc
     */
    public function range(mixed $lo, mixed $hi): iterable
    {
        return $this->tree->rangeKeys($lo, $hi);
    }

    /**
     * @inheritDoc
     */
    public function rangeCount(mixed $lo, mixed $hi): int
    {
        return $this->tree->rangeCount($lo, $hi);
    }

    /**
     * @inheritDoc
     */
    public function floor(mixed $item): mixed
    {
        return $this->tree->floor($item);
    }

    /**
     * @inheritDoc
     */
    public function ceiling(mixed $item): mixed
    {
        return $this->tree->ceiling($item);
    }

    /**
     * @inheritDoc
     */
    public function rank(mixed $item): int
    {
        return $this->tree->rank($item);
    }

    /**
     * @inheritDoc
     */
    public function select(int $rank): mixed
    {
        return $this->tree->select($rank);
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
    public function map(callable $callback, Comparator $comparator, ?string $itemType = null): static
    {
        $set = static::create($comparator, $itemType);

        foreach ($this->getIterator() as $index => $item) {
            $set->add(call_user_func($callback, $item, $index));
        }

        return $set;
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

        return $this->tree->max();
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

        return $this->tree->min();
    }

    /**
     * @inheritDoc
     */
    public function removeMin(?callable $callback = null): void
    {
        if ($callback === null) {
            $this->tree->removeMin();

            return;
        }

        $this->remove($this->min($callback));
    }

    /**
     * @inheritDoc
     */
    public function removeMax(?callable $callback = null): void
    {
        if ($callback === null) {
            $this->tree->removeMax();

            return;
        }

        $this->remove($this->max($callback));
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
        $set = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $set->add($item);
            }
        }

        return $set;
    }

    /**
     * @inheritDoc
     */
    public function reject(callable $predicate): static
    {
        $set = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
                $set->add($item);
            }
        }

        return $set;
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
        $set1 = static::create($this->comparator, $this->itemType());
        $set2 = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $set1->add($item);
            } else {
                $set2->add($item);
            }
        }

        return [$set1, $set2];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new GeneratorIterator(function (iterable $keys) {
            $index = 0;
            foreach ($keys as $key) {
                yield $index => $key;
                $index++;
            }
        }, [$this->tree->keys()]);
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
        $tree = clone $this->tree;
        $this->tree = $tree;
    }
}
