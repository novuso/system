<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Api\SymbolTable;
use Novuso\System\Collection\Chain\TableBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\KeyValueTypeMethods;
use Novuso\System\Exception\KeyException;
use Novuso\System\Utility\FastHasher;
use Novuso\System\Utility\Validate;
use Novuso\System\Utility\VarPrinter;
use Traversable;

/**
 * HashTable is an implementation of the symbol table type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class HashTable implements SymbolTable
{
    use KeyValueTypeMethods;

    /**
     * Bucket chains
     *
     * @var array
     */
    protected $buckets;

    /**
     * Bucket count
     *
     * @var int
     */
    protected $count;

    /**
     * Constructs HashTable
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     */
    public function __construct(string $keyType = null, string $valueType = null)
    {
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
        $this->buckets = [];
        $this->count = 0;
    }

    /**
     * Creates collection with specific key and value types
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType   The key type
     * @param string|null $valueType The value type
     *
     * @return HashTable
     */
    public static function of(string $keyType = null, string $valueType = null): HashTable
    {
        return new static($keyType, $valueType);
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
    public function set($key, $value)
    {
        assert(
            Validate::isType($key, $this->keyType()),
            $this->keyTypeError('set', $key)
        );
        assert(
            Validate::isType($value, $this->valueType()),
            $this->valueTypeError('set', $value)
        );

        $hash = FastHasher::hash($key);

        if (!isset($this->buckets[$hash])) {
            $this->buckets[$hash] = new TableBucketChain();
        }

        if ($this->buckets[$hash]->set($key, $value)) {
            $this->count++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $hash = FastHasher::hash($key);

        if (!isset($this->buckets[$hash])) {
            $message = sprintf('Key not found: %s', VarPrinter::toString($key));
            throw new KeyException($message);
        }

        return $this->buckets[$hash]->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key): bool
    {
        $hash = FastHasher::hash($key);

        if (!isset($this->buckets[$hash])) {
            return false;
        }

        return $this->buckets[$hash]->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $hash = FastHasher::hash($key);

        if (isset($this->buckets[$hash])) {
            if ($this->buckets[$hash]->remove($key)) {
                $this->count--;
                if ($this->buckets[$hash]->isEmpty()) {
                    unset($this->buckets[$hash]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value)
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
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): Traversable
    {
        return call_user_func(function (array $buckets) {
            foreach ($buckets as $chain) {
                for ($chain->rewind(); $chain->valid(); $chain->next()) {
                    yield $chain->key();
                }
            }
        }, $this->buckets);
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callback)
    {
        foreach ($this->getIterator() as $key => $value) {
            call_user_func($callback, $value, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, string $valueType = null): HashTable
    {
        $table = static::of($this->keyType(), $valueType);

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
    public function filter(callable $predicate): HashTable
    {
        $table = static::of($this->keyType(), $this->valueType());

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
    public function reject(callable $predicate): HashTable
    {
        $table = static::of($this->keyType(), $this->valueType());

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
        $table1 = static::of($this->keyType(), $this->valueType());
        $table2 = static::of($this->keyType(), $this->valueType());

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
        return new GeneratorIterator(function (SymbolTable $table) {
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
        $buckets = [];

        foreach ($this->buckets as $hash => $chain) {
            $buckets[$hash] = clone $chain;
        }

        $this->buckets = $buckets;
    }
}
