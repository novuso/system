<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Collection\Comparison\FunctionComparator;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Mixin\ItemTypeMethods;
use Novuso\System\Collection\Tree\BinarySearchTree;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Collection\Type\OrderedSet;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;

/**
 * Class SortedSet
 */
final class SortedSet implements OrderedSet
{
    use ItemTypeMethods;

    /**
     * Binary search tree
     *
     * @var BinarySearchTree
     */
    protected $tree;

    /**
     * Comparator
     *
     * @var Comparator
     */
    protected $comparator;

    /**
     * Constructs SortedSet
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $itemType   The item type
     */
    public function __construct(Comparator $comparator, ?string $itemType = null)
    {
        $this->setItemType($itemType);
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
    }

    /**
     * Creates collection with a custom comparator
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $itemType   The item type
     *
     * @return SortedSet
     */
    public static function create(Comparator $comparator, ?string $itemType = null): SortedSet
    {
        return new static($comparator, $itemType);
    }

    /**
     * Creates collection of comparable items
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The item type must be a fully-qualified class name that implements:
     * `Novuso\System\Type\Comparable`
     *
     * @param string|null $itemType The item type
     *
     * @return SortedSet
     *
     * @throws AssertionException When the item type is not valid
     */
    public static function comparable(?string $itemType = null): SortedSet
    {
        Assert::isTrue(Validate::isNull($itemType) || Validate::implementsInterface($itemType, Comparable::class));

        return new static(new ComparableComparator(), $itemType);
    }

    /**
     * Creates collection of items sorted by callback
     *
     * The callback should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * Callback signature:
     *
     * <code>
     * function (<I> $item1, <I> $item2): int {}
     * </code>
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param callable    $callback The sorting callback function
     * @param string|null $itemType The item type
     *
     * @return SortedSet
     */
    public static function callback(callable $callback, ?string $itemType = null): SortedSet
    {
        return new static(new FunctionComparator($callback), $itemType);
    }

    /**
     * Creates collection of floats
     *
     * @return SortedSet
     */
    public static function float(): SortedSet
    {
        return new static(new FloatComparator(), 'float');
    }

    /**
     * Creates collection of integers
     *
     * @return SortedSet
     */
    public static function integer(): SortedSet
    {
        return new static(new IntegerComparator(), 'int');
    }

    /**
     * Creates collection of strings
     *
     * @return SortedSet
     */
    public static function string(): SortedSet
    {
        return new static(new StringComparator(), 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->tree->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->tree->count();
    }

    /**
     * {@inheritdoc}
     */
    public function add($item): void
    {
        Assert::isType($item, $this->itemType());
        $this->tree->set($item, true);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($item): bool
    {
        return $this->tree->has($item);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item): void
    {
        $this->tree->remove($item);
    }

    /**
     * {@inheritdoc}
     */
    public function difference(OrderedSet $other)
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
     * {@inheritdoc}
     */
    public function intersection(OrderedSet $other)
    {
        $intersection = static::create($this->comparator, $this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * {@inheritdoc}
     */
    public function complement(OrderedSet $other)
    {
        $complement = static::create($this->comparator, $this->itemType());

        if ($this === $other) {
            return $complement;
        }

        $other->reject([$this, 'contains'])->each([$complement, 'add']);

        return $complement;
    }

    /**
     * {@inheritdoc}
     */
    public function union(OrderedSet $other)
    {
        $union = static::create($this->comparator, $this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
    }

    /**
     * {@inheritdoc}
     */
    public function range($lo, $hi): iterable
    {
        return $this->tree->rangeKeys($lo, $hi);
    }

    /**
     * {@inheritdoc}
     */
    public function rangeCount($lo, $hi): int
    {
        return $this->tree->rangeCount($lo, $hi);
    }

    /**
     * {@inheritdoc}
     */
    public function floor($item)
    {
        return $this->tree->floor($item);
    }

    /**
     * {@inheritdoc}
     */
    public function ceiling($item)
    {
        return $this->tree->ceiling($item);
    }

    /**
     * {@inheritdoc}
     */
    public function rank($item): int
    {
        return $this->tree->rank($item);
    }

    /**
     * {@inheritdoc}
     */
    public function select(int $rank)
    {
        return $this->tree->select($rank);
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
    public function map(callable $callback, Comparator $comparator, ?string $itemType = null)
    {
        $set = static::create($comparator, $itemType);

        foreach ($this->getIterator() as $index => $item) {
            $set->add(call_user_func($callback, $item, $index));
        }

        return $set;
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

        return $this->tree->max();
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

        return $this->tree->min();
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
        $set = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $set->add($item);
            }
        }

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
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
     * {@inheritdoc}
     */
    public function getIterator()
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
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $tree = clone $this->tree;
        $this->tree = $tree;
    }
}
