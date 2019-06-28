<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Comparison\ComparableComparator;
use Novuso\System\Collection\Comparison\FloatComparator;
use Novuso\System\Collection\Comparison\FunctionComparator;
use Novuso\System\Collection\Comparison\IntegerComparator;
use Novuso\System\Collection\Comparison\StringComparator;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Mixin\KeyValueTypeMethods;
use Novuso\System\Collection\Tree\BinarySearchTree;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Collection\Type\OrderedTable;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;

/**
 * Class SortedTable
 */
final class SortedTable implements OrderedTable
{
    use KeyValueTypeMethods;

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
     * Constructs SortedTable
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $keyType    The key type
     * @param string|null $valueType  The value type
     */
    public function __construct(Comparator $comparator, ?string $keyType = null, ?string $valueType = null)
    {
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
    }

    /**
     * Creates collection with a custom comparator
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $keyType    The key type
     * @param string|null $valueType  The value type
     *
     * @return SortedTable
     */
    public static function create(
        Comparator $comparator,
        ?string $keyType = null,
        ?string $valueType = null
    ): SortedTable {
        return new static($comparator, $keyType, $valueType);
    }

    /**
     * Creates collection with comparable keys
     *
     * If types are not provided, the types are dynamic.
     *
     * The key type must be a fully-qualified class name that implements:
     * `Novuso\System\Type\Comparable`
     *
     * The value type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     *
     * @return SortedTable
     *
     * @throws AssertionException When the key type is not valid
     */
    public static function comparable(?string $keyType = null, ?string $valueType = null): SortedTable
    {
        Assert::isTrue(Validate::isNull($keyType) || Validate::implementsInterface($keyType, Comparable::class));

        return new static(new ComparableComparator(), $keyType, $valueType);
    }

    /**
     * Creates collection sorted by callback
     *
     * The callback should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * Callback signature:
     *
     * <code>
     * function (<K> $key1, <K> $key2): int {}
     * </code>
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param callable    $callback  The sorting callback function
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     *
     * @return SortedTable
     */
    public static function callback(callable $callback, ?string $keyType = null, ?string $valueType = null): SortedTable
    {
        return new static(new FunctionComparator($callback), $keyType, $valueType);
    }

    /**
     * Creates collection with float keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return SortedTable
     */
    public static function float(?string $valueType = null): SortedTable
    {
        return new static(new FloatComparator(), 'float', $valueType);
    }

    /**
     * Creates collection with integer keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return SortedTable
     */
    public static function integer(?string $valueType = null): SortedTable
    {
        return new static(new IntegerComparator(), 'int', $valueType);
    }

    /**
     * Creates collection with string keys
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type
     *
     * @return SortedTable
     */
    public static function string(?string $valueType = null): SortedTable
    {
        return new static(new StringComparator(), 'string', $valueType);
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
    public function set($key, $value): void
    {
        Assert::isType($key, $this->keyType());
        Assert::isType($value, $this->valueType());
        $this->tree->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->tree->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key): bool
    {
        return $this->tree->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key): void
    {
        $this->tree->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($key): bool
    {
        return $this->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key): void
    {
        $this->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): iterable
    {
        return $this->tree->keys();
    }

    /**
     * {@inheritdoc}
     */
    public function rangeKeys($lo, $hi): iterable
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
    public function floor($key)
    {
        return $this->tree->floor($key);
    }

    /**
     * {@inheritdoc}
     */
    public function ceiling($key)
    {
        return $this->tree->ceiling($key);
    }

    /**
     * {@inheritdoc}
     */
    public function rank($key): int
    {
        return $this->tree->rank($key);
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
        foreach ($this->getIterator() as $key => $value) {
            call_user_func($callback, $value, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $valueType = null)
    {
        $table = static::create($this->comparator, $this->keyType(), $valueType);

        foreach ($this->getIterator() as $key => $value) {
            $table->set($key, call_user_func($callback, $value, $key));
        }

        return $table;
    }

    /**
     * {@inheritdoc}
     */
    public function max(?callable $callback = null)
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
     * {@inheritdoc}
     */
    public function min(?callable $callback = null)
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

        foreach ($this->getIterator() as $key => $value) {
            $accumulator = call_user_func($callback, $accumulator, $value, $key);
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
            $callback = function ($value) {
                return $value;
            };
        }

        return $this->reduce(function ($total, $value, $key) use ($callback) {
            return $total + call_user_func($callback, $value, $key);
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
        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $predicate)
    {
        $table = static::create($this->comparator, $this->keyType(), $this->valueType());

        foreach ($this->getIterator() as $key => $value) {
            if (call_user_func($predicate, $value, $key)) {
                $table->set($key, $value);
            }
        }

        return $table;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
    {
        $table = static::create($this->comparator, $this->keyType(), $this->valueType());

        foreach ($this->getIterator() as $key => $value) {
            if (!call_user_func($predicate, $value, $key)) {
                $table->set($key, $value);
            }
        }

        return $table;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function partition(callable $predicate): array
    {
        $table1 = static::create($this->comparator, $this->keyType(), $this->valueType());
        $table2 = static::create($this->comparator, $this->keyType(), $this->valueType());

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
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new GeneratorIterator(function (OrderedTable $table) {
            foreach ($table->keys() as $key) {
                yield $key => $table->get($key);
            }
        }, [$this]);
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
