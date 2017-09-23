<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Api\OrderedSet;
use Novuso\System\Collection\Compare\ComparableComparator;
use Novuso\System\Collection\Compare\FloatComparator;
use Novuso\System\Collection\Compare\IntegerComparator;
use Novuso\System\Collection\Compare\StringComparator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Type\Arrayable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * SortedSet is an implementation of the sorted set type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class SortedSet implements Arrayable, OrderedSet
{
    use ItemTypeMethods;

    /**
     * Binary search tree
     *
     * @var RedBlackSearchTree
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
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
        $this->setItemType($itemType);
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
     */
    public static function comparable(?string $itemType = null): SortedSet
    {
        assert(
            Validate::isNull($itemType) || Validate::implementsInterface($itemType, Comparable::class),
            sprintf('%s expects $itemType to implement %s', __METHOD__, Comparable::class)
        );

        return new static(new ComparableComparator(), $itemType);
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
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('add', $item)
        );

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
    public function difference(OrderedSet $other): SortedSet
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
    public function intersection(OrderedSet $other): SortedSet
    {
        $intersection = static::create($this->comparator, $this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * {@inheritdoc}
     */
    public function complement(OrderedSet $other): SortedSet
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
    public function union(OrderedSet $other): SortedSet
    {
        $union = static::create($this->comparator, $this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
    }

    /**
     * {@inheritdoc}
     */
    public function range($lo, $hi): Traversable
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
    public function min()
    {
        return $this->tree->min();
    }

    /**
     * {@inheritdoc}
     */
    public function max()
    {
        return $this->tree->max();
    }

    /**
     * {@inheritdoc}
     */
    public function removeMin(): void
    {
        $this->tree->removeMin();
    }

    /**
     * {@inheritdoc}
     */
    public function removeMax(): void
    {
        $this->tree->removeMax();
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
        foreach ($this->getIterator() as $item) {
            call_user_func($callback, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, Comparator $comparator, ?string $itemType = null): SortedSet
    {
        $set = static::create($comparator, $itemType);

        foreach ($this->getIterator() as $item) {
            $set->add(call_user_func($callback, $item));
        }

        return $set;
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
    public function filter(callable $predicate): SortedSet
    {
        $set = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
                $set->add($item);
            }
        }

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate): SortedSet
    {
        $set = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $item) {
            if (!call_user_func($predicate, $item)) {
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
        $set1 = static::create($this->comparator, $this->itemType());
        $set2 = static::create($this->comparator, $this->itemType());

        foreach ($this->getIterator() as $item) {
            if (call_user_func($predicate, $item)) {
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
    public function getIterator(): Traversable
    {
        return $this->tree->keys();
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
