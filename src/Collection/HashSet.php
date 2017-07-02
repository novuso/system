<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Api\Set;
use Novuso\System\Collection\Chain\SetBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Traits\ItemTypeMethods;
use Novuso\System\Type\Arrayable;
use Novuso\System\Utility\FastHasher;
use Novuso\System\Utility\Validate;
use Traversable;

/**
 * HashSet is an implementation of the set type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class HashSet implements Arrayable, Set
{
    use ItemTypeMethods;

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
     * Constructs HashSet
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     */
    public function __construct(?string $itemType = null)
    {
        $this->setItemType($itemType);
        $this->buckets = [];
        $this->count = 0;
    }

    /**
     * Creates collection of a specific item type
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     *
     * @return HashSet
     */
    public static function of(?string $itemType = null): HashSet
    {
        return new static($itemType);
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
    public function add($item): void
    {
        assert(
            Validate::isType($item, $this->itemType()),
            $this->itemTypeError('add', $item)
        );

        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            $this->buckets[$hash] = new SetBucketChain();
        }

        if ($this->buckets[$hash]->add($item)) {
            $this->count++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function contains($item): bool
    {
        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            return false;
        }

        return $this->buckets[$hash]->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item): void
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
     * {@inheritdoc}
     */
    public function difference(Set $other): HashSet
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
     * {@inheritdoc}
     */
    public function intersection(Set $other): HashSet
    {
        $intersection = static::of($this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * {@inheritdoc}
     */
    public function complement(Set $other): HashSet
    {
        $complement = static::of($this->itemType());

        if ($this === $other) {
            return $complement;
        }

        $other->reject([$this, 'contains'])->each([$complement, 'add']);

        return $complement;
    }

    /**
     * {@inheritdoc}
     */
    public function union(Set $other): HashSet
    {
        $union = static::of($this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
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
    public function map(callable $callback, ?string $itemType = null): HashSet
    {
        $set = static::of($itemType);

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
    public function filter(callable $predicate): HashSet
    {
        $set = static::of($this->itemType());

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
    public function reject(callable $predicate): HashSet
    {
        $set = static::of($this->itemType());

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
        $set1 = static::of($this->itemType());
        $set2 = static::of($this->itemType());

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
        return new GeneratorIterator(function (array $buckets) {
            foreach ($buckets as $chain) {
                for ($chain->rewind(); $chain->valid(); $chain->next()) {
                    yield $chain->current();
                }
            }
        }, [$this->buckets]);
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
        $buckets = [];

        foreach ($this->buckets as $hash => $chain) {
            $buckets[$hash] = clone $chain;
        }

        $this->buckets = $buckets;
    }
}
