<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Chain\SetBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Collection\Type\Set;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\FastHasher;
use Traversable;

/**
 * Class HashSet
 */
final class HashSet implements Set
{
    use ItemTypeMethods;

    protected array $buckets = [];
    protected int $count = 0;

    /**
     * Constructs HashSet
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    public function __construct(?string $itemType = null)
    {
        $this->setItemType($itemType);
    }

    /**
     * @inheritDoc
     */
    public static function of(?string $itemType = null): static
    {
        return new static($itemType);
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
    public function add(mixed $item): void
    {
        Assert::isType($item, $this->itemType());

        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            $this->buckets[$hash] = new SetBucketChain();
        }

        if ($this->buckets[$hash]->add($item)) {
            $this->count++;
        }
    }

    /**
     * @inheritDoc
     */
    public function contains(mixed $item): bool
    {
        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            return false;
        }

        return $this->buckets[$hash]->contains($item);
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $item): void
    {
        $hash = FastHasher::hash($item);

        if (isset($this->buckets[$hash])) {
            if ($this->buckets[$hash]->remove($item)) {
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
    public function difference(Set $other): static
    {
        $difference = static::of($this->itemType());

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
    public function intersection(Set $other): static
    {
        $intersection = static::of($this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * @inheritDoc
     */
    public function complement(Set $other): static
    {
        $complement = static::of($this->itemType());

        if ($this === $other) {
            return $complement;
        }

        $other->reject([$this, 'contains'])->each([$complement, 'add']);

        return $complement;
    }

    /**
     * @inheritDoc
     */
    public function union(Set $other): static
    {
        $union = static::of($this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
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
    public function map(callable $callback, ?string $itemType = null): static
    {
        $set = static::of($itemType);

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

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item > $accumulator ? $item : $accumulator;
        });
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

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item < $accumulator ? $item : $accumulator;
        });
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
        $set = static::of($this->itemType());

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
        $set = static::of($this->itemType());

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
        $set1 = static::of($this->itemType());
        $set2 = static::of($this->itemType());

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
        return new GeneratorIterator(function (array $buckets) {
            $index = 0;
            /** @var SetBucketChain $chain */
            foreach ($buckets as $chain) {
                for ($chain->rewind(); $chain->valid(); $chain->next()) {
                    yield $index => $chain->current();
                    $index++;
                }
            }
        }, [$this->buckets]);
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
        $buckets = [];

        foreach ($this->buckets as $hash => $chain) {
            $buckets[$hash] = clone $chain;
        }

        $this->buckets = $buckets;
    }
}
