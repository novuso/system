<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Chain\TableBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\KeyValueTypeMethods;
use Novuso\System\Collection\Type\Table;
use Novuso\System\Exception\KeyException;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\FastHasher;
use Novuso\System\Utility\VarPrinter;
use Traversable;

/**
 * Class HashTable
 */
final class HashTable implements Table
{
    use KeyValueTypeMethods;

    protected array $buckets = [];
    protected int $count = 0;

    /**
     * Constructs HashTable
     *
     * If types are not provided, the types are dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public function __construct(?string $keyType = null, ?string $valueType = null)
    {
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
    }

    /**
     * @inheritDoc
     */
    public static function of(?string $keyType = null, ?string $valueType = null): static
    {
        return new static($keyType, $valueType);
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
    public function set(mixed $key, mixed $value): void
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
     * @inheritDoc
     */
    public function get(mixed $key): mixed
    {
        $hash = FastHasher::hash($key);

        if (!isset($this->buckets[$hash])) {
            $message = sprintf(
                'Key not found: %s',
                VarPrinter::toString($key)
            );
            throw new KeyException($message);
        }

        return $this->buckets[$hash]->get($key);
    }

    /**
     * @inheritDoc
     */
    public function has(mixed $key): bool
    {
        $hash = FastHasher::hash($key);

        if (!isset($this->buckets[$hash])) {
            return false;
        }

        return $this->buckets[$hash]->has($key);
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $key): void
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
        $table = static::of($this->keyType(), $valueType);

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
        $table = static::of($this->keyType(), $this->valueType());

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
        $table = static::of($this->keyType(), $this->valueType());

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
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new GeneratorIterator(function (Table $table) {
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
        $buckets = [];

        foreach ($this->buckets as $hash => $chain) {
            $buckets[$hash] = clone $chain;
        }

        $this->buckets = $buckets;
    }
}
