<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Collection\Comparison\FunctionComparator;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\KeyValueTypeMethods;
use Novuso\System\Collection\Tree\BinarySearchTree;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Collection\Type\OrderedTable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * Class SortedTable
 */
final class SortedTable implements OrderedTable
{
    use KeyValueTypeMethods;

    protected BinarySearchTree $tree;
    protected Comparator $comparator;

    /**
     * Constructs SortedTable
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public function __construct(Comparator $comparator, ?string $keyType = null, ?string $valueType = null)
    {
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
    }

    /**
     * @inheritDoc
     */
    public static function create(
        Comparator $comparator,
        ?string $keyType = null,
        ?string $valueType = null
    ): static {
        return new static($comparator, $keyType, $valueType);
    }

    /**
     * @inheritDoc
     */
    public static function comparable(?string $keyType = null, ?string $valueType = null): static
    {
        Assert::isTrue(Validate::isNull($keyType)
            || Validate::implementsInterface($keyType, Comparable::class));

        return new static(new ComparableComparator(), $keyType, $valueType);
    }

    /**
     * @inheritDoc
     */
    public static function callback(callable $callback, ?string $keyType = null, ?string $valueType = null): static
    {
        return new static(
            new FunctionComparator($callback),
            $keyType,
            $valueType
        );
    }

    /**
     * @inheritDoc
     */
    public static function float(?string $valueType = null): static
    {
        return new static(new FloatComparator(), 'float', $valueType);
    }

    /**
     * @inheritDoc
     */
    public static function integer(?string $valueType = null): static
    {
        return new static(new IntegerComparator(), 'int', $valueType);
    }

    /**
     * @inheritDoc
     */
    public static function string(?string $valueType = null): static
    {
        return new static(new StringComparator(), 'string', $valueType);
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
    public function set(mixed $key, mixed $value): void
    {
        Assert::isType($key, $this->keyType());
        Assert::isType($value, $this->valueType());
        $this->tree->set($key, $value);
    }

    /**
     * @inheritDoc
     */
    public function get(mixed $key): mixed
    {
        return $this->tree->get($key);
    }

    /**
     * @inheritDoc
     */
    public function has(mixed $key): bool
    {
        return $this->tree->has($key);
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $key): void
    {
        $this->tree->remove($key);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $key): mixed
    {
        return $this->get($key);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $key): bool
    {
        return $this->has($key);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $key): void
    {
        $this->remove($key);
    }

    /**
     * @inheritDoc
     */
    public function keys(): iterable
    {
        return $this->tree->keys();
    }

    /**
     * @inheritDoc
     */
    public function rangeKeys(mixed $lo, mixed $hi): iterable
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
    public function floor(mixed $key): mixed
    {
        return $this->tree->floor($key);
    }

    /**
     * @inheritDoc
     */
    public function ceiling(mixed $key): mixed
    {
        return $this->tree->ceiling($key);
    }

    /**
     * @inheritDoc
     */
    public function rank(mixed $key): int
    {
        return $this->tree->rank($key);
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
        foreach ($this->getIterator() as $key => $value) {
            call_user_func($callback, $value, $key);
        }
    }

    /**
     * @inheritDoc
     */
    public function map(callable $callback, ?string $valueType = null): static
    {
        $table = static::create(
            $this->comparator,
            $this->keyType(),
            $valueType
        );

        foreach ($this->getIterator() as $key => $value) {
            $table->set($key, call_user_func($callback, $value, $key));
        }

        return $table;
    }

    /**
     * @inheritDoc
     */
    public function max(?callable $callback = null): mixed
    {
        if ($callback !== null) {
            $maxKey = null;
            $max = null;

            foreach ($this->getIterator() as $key => $value) {
                $field = call_user_func($callback, $value, $key);
                if ($max === null || $field > $max) {
                    $max = $field;
                    $maxKey = $key;
                }
            }

            return $maxKey;
        }

        return $this->tree->max();
    }

    /**
     * @inheritDoc
     */
    public function min(?callable $callback = null): mixed
    {
        if ($callback !== null) {
            $minKey = null;
            $min = null;

            foreach ($this->getIterator() as $key => $value) {
                $field = call_user_func($callback, $value, $key);
                if ($min === null || $field < $min) {
                    $min = $field;
                    $minKey = $key;
                }
            }

            return $minKey;
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

        foreach ($this->getIterator() as $key => $value) {
            $accumulator = call_user_func(
                $callback,
                $accumulator,
                $value,
                $key
            );
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
            $callback = function ($value) {
                return $value;
            };
        }

        return $this->reduce(function ($total, $value, $key) use ($callback) {
            return $total + call_user_func($callback, $value, $key);
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
        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $predicate): static
    {
        $table = static::create(
            $this->comparator,
            $this->keyType(),
            $this->valueType()
        );

        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
                $table->set($key, $value);
            }
        }

        return $table;
    }

    /**
     * @inheritDoc
     */
    public function reject(callable $predicate): static
    {
        $table = static::create(
            $this->comparator,
            $this->keyType(),
            $this->valueType()
        );

        foreach ($this->getIterator() as $key => $value) {
            if (!call_user_func($predicate, $value, $key)) {
                $table->set($key, $value);
            }
        }

        return $table;
    }

    /**
     * @inheritDoc
     */
    public function any(callable $predicate): bool
    {
        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
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
        foreach ($this->getIterator() as $key => $value) {
            if (!call_user_func($predicate, $value, $key)) {
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
        $table1 = static::create(
            $this->comparator,
            $this->keyType(),
            $this->valueType()
        );
        $table2 = static::create(
            $this->comparator,
            $this->keyType(),
            $this->valueType()
        );

        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
                $table1->set($key, $value);
            } else {
                $table2->set($key, $value);
            }
        }

        return [$table1, $table2];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new GeneratorIterator(function (OrderedTable $table) {
            foreach ($table->keys() as $key) {
                yield $key => $table->get($key);
            }
        }, [$this]);
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
