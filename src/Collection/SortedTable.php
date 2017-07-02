<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Api\OrderedTable;
use Novuso\System\Collection\Compare\ComparableComparator;
use Novuso\System\Collection\Compare\FloatComparator;
use Novuso\System\Collection\Compare\IntegerComparator;
use Novuso\System\Collection\Compare\StringComparator;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\KeyValueTypeMethods;
use Novuso\System\Collection\Tree\RedBlackSearchTree;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * SortedTable is an implementation of the ordered table type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class SortedTable implements OrderedTable
{
    use KeyValueTypeMethods;

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
     * Constructs SortedTable
     *
     * @param Comparator  $comparator The comparator
     * @param string|null $keyType    The key type
     * @param string|null $valueType  The value type
     */
    public function __construct(Comparator $comparator, ?string $keyType = null, ?string $valueType = null)
    {
        $this->comparator = $comparator;
        $this->tree = new RedBlackSearchTree($this->comparator);
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
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
     */
    public static function comparable(?string $keyType = null, ?string $valueType = null): SortedTable
    {
        assert(
            Validate::isNull($keyType) || Validate::implementsInterface($keyType, Comparable::class),
            sprintf('%s expects $keyType to implement %s', __METHOD__, Comparable::class)
        );

        return new static(new ComparableComparator(), $keyType, $valueType);
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
        assert(
            Validate::isType($key, $this->keyType()),
            $this->keyTypeError('set', $key)
        );
        assert(
            Validate::isType($value, $this->valueType()),
            $this->valueTypeError('set', $value)
        );

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
    public function keys(): Traversable
    {
        return $this->tree->keys();
    }

    /**
     * {@inheritdoc}
     */
    public function rangeKeys($lo, $hi): Traversable
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
    public function map(callable $callback, ?string $valueType = null): SortedTable
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
    public function filter(callable $predicate): SortedTable
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
    public function reject(callable $predicate): SortedTable
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
     *
     * @return void
     */
    public function __clone()
    {
        $tree = clone $this->tree;
        $this->tree = $tree;
    }
}
