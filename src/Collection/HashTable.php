<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Chain\TableBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Mixin\KeyValueTypeMethods;
use Novuso\System\Collection\Type\Table;
use Novuso\System\Exception\KeyException;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\FastHasher;
use Novuso\System\Utility\VarPrinter;

/**
 * Class HashTable
 */
final class HashTable implements Table
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
    public function __construct(?string $keyType = null, ?string $valueType = null)
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
    public static function of(?string $keyType = null, ?string $valueType = null): HashTable
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
    public function set($key, $value): void
    {
        Assert::isType($key, $this->keyType());
        Assert::isType($value, $this->valueType());

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
    public function remove($key): void
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
        return new GeneratorIterator(function (array $buckets) {
            /** @var TableBucketChain $chain */
            foreach ($buckets as $chain) {
                for ($chain->rewind(); $chain->valid(); $chain->next()) {
                    yield $chain->key();
                }
            }
        }, [$this->buckets]);
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
        $table = static::of($this->keyType(), $valueType);

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

        $maxKey = null;
        $max = null;

        foreach ($this->getIterator() as $key => $value) {
            if ($max === null || $value > $max) {
                $max = $value;
                $maxKey = $key;
            }
        }

        return $maxKey;
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

        $minKey = null;
        $min = null;

        foreach ($this->getIterator() as $key => $value) {
            if ($min === null || $value < $min) {
                $min = $value;
                $minKey = $key;
            }
        }

        return $minKey;
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
    public function reject(callable $predicate)
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
    public function getIterator()
    {
        return new GeneratorIterator(function (Table $table) {
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
