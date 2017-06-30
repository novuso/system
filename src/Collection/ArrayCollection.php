<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use ArrayAccess;
use ArrayIterator;
use JsonSerializable;
use Novuso\System\Collection\Api\Collection;
use Novuso\System\Exception\DomainException;
use Novuso\System\Type\Arrayable;
use Traversable;

/**
 * ArrayCollection is a collection for operating on array values
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ArrayCollection implements Arrayable, ArrayAccess, Collection, JsonSerializable
{
    /**
     * Collection items
     *
     * @var array
     */
    protected $items = [];

    /**
     * Constructs ArrayCollection
     *
     * @param array $items The items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Creates an instance
     *
     * @param array $items The items
     *
     * @return ArrayCollection
     */
    public static function create(array $items = []): ArrayCollection
    {
        return new static($items);
    }

    /**
     * Checks if empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Retrieves the count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Adds a value
     *
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function add($value): ArrayCollection
    {
        return $this->set(null, $value);
    }

    /**
     * Alias for add
     *
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function append($value): ArrayCollection
    {
        return $this->add($value);
    }

    /**
     * Alias for add
     *
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function push($value): ArrayCollection
    {
        return $this->add($value);
    }

    /**
     * Prepends a value
     *
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function prepend($value): ArrayCollection
    {
        array_unshift($this->items, $value);

        return $this;
    }

    /**
     * Sets a value
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function set($key, $value): ArrayCollection
    {
        if ($key === null) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }

        return $this;
    }

    /**
     * Alias for set
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function put($key, $value): ArrayCollection
    {
        return $this->set($key, $value);
    }

    /**
     * Prepends a keyed value
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return ArrayCollection
     */
    public function prependSet($key, $value): ArrayCollection
    {
        $this->items = [$key => $value] + $this->items;

        return $this;
    }

    /**
     * Retrieves a value
     *
     * @param mixed $key     The key
     * @param mixed $default A default value
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!(isset($this->items[$key]) || array_key_exists($key, $this->items))) {
            return $default;
        }

        return $this->items[$key];
    }

    /**
     * Checks if a key exists
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->items[$key]) || array_key_exists($key, $this->items);
    }

    /**
     * Removes a value by key
     *
     * @param mixed $key The key
     *
     * @return ArrayCollection
     */
    public function remove($key): ArrayCollection
    {
        unset($this->items[$key]);

        return $this;
    }

    /**
     * Sets a value
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Retrieves a value
     *
     * @param mixed $key The key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Checks if a key exists
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Removes a value by key
     *
     * @param mixed $key The key
     *
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->remove($key);
    }

    /**
     * Retrieves and removes a value
     *
     * @param mixed $key The key
     *
     * @return mixed
     */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);

        return $value;
    }

    /**
     * Alias for pull
     *
     * @param mixed $key The key
     *
     * @return mixed
     */
    public function extract($key)
    {
        return $this->pull($key);
    }

    /**
     * Retrieves and removes the first item from the collection
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Retrieves and removes the last item from the collection
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Removes and returns a portion of the collection
     *
     * Replacement items will replace removed items in the collection.
     *
     * @param int      $offset      The starting offset
     * @param int|null $length      The length or null for remaining
     * @param array    $replacement The replacement items
     *
     * @return ArrayCollection
     */
    public function splice(int $offset, ?int $length = null, array $replacement = []): ArrayCollection
    {
        if ($length === null && empty($replacement)) {
            return new static(array_splice($this->items, $offset));
        }

        if ($length === null) {
            $length = $this->count();
        }

        return new static(array_splice($this->items, $offset, $length, $replacement));
    }

    /**
     * Checks if a value exists
     *
     * @param mixed $value  The value
     * @param bool  $strict Whether comparison should be strict
     *
     * @return bool
     */
    public function contains($value, bool $strict = true): bool
    {
        return in_array($value, $this->items, $strict);
    }

    /**
     * Retrieves the key for a given value
     *
     * Returns FALSE if the value is not found.
     *
     * @param mixed $value  The value
     * @param bool  $strict Whether comparison should be strict
     *
     * @return mixed
     */
    public function search($value, bool $strict = true)
    {
        return array_search($value, $this->items, $strict);
    }

    /**
     * Retrieves items in the collection
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Creates a collection with the collection keys
     *
     * @return ArrayCollection
     */
    public function keys(): ArrayCollection
    {
        return new static(array_keys($this->items));
    }

    /**
     * Creates a collection with the collection values
     *
     * @return ArrayCollection
     */
    public function values(): ArrayCollection
    {
        return new static(array_values($this->items));
    }

    /**
     * Creates a flipped collection
     *
     * @return ArrayCollection
     */
    public function flip(): ArrayCollection
    {
        return new static(array_flip($this->items));
    }

    /**
     * Checks if any items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function any(callable $predicate): bool
    {
        foreach ($this->items as $key => $value) {
            if ($predicate($value, $key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if every item passes a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function every(callable $predicate): bool
    {
        foreach ($this->items as $key => $value) {
            if (!$predicate($value, $key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retrieves the first value from the collection
     *
     * Optionally retrieves the first value that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable|null $predicate The predicate function
     * @param mixed         $default   The default return value
     *
     * @return mixed
     */
    public function first(?callable $predicate = null, $default = null)
    {
        if ($predicate === null) {
            return $this->isEmpty() ? $default : reset($this->items);
        }

        foreach ($this->items as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Retrieves the last value from the collection
     *
     * Optionally retrieves the last value that passes a truth test.
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable|null $predicate The predicate function
     * @param mixed         $default   The default return value
     *
     * @return mixed
     */
    public function last(?callable $predicate = null, $default = null)
    {
        if ($predicate === null) {
            return $this->isEmpty() ? $default : end($this->items);
        }

        foreach (array_reverse($this->items, true) as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Retrieves items randomly
     *
     * @param int $amount The number of items
     *
     * @return mixed
     *
     * @throws DomainException When amount is greater than item count
     */
    public function random(int $amount = 1)
    {
        $count = $this->count();
        if ($amount > $count) {
            $message = sprintf('Requested %d items with %d items present', $amount, $count);
            throw new DomainException($message);
        }

        $keys = array_rand($this->items, $amount);

        if ($amount === 1) {
            return $this->items[$keys];
        }

        return new static(array_intersect_key($this->items, array_flip($keys)));
    }

    /**
     * Creates a collection with items shuffled
     *
     * @return ArrayCollection
     */
    public function shuffle(): ArrayCollection
    {
        $items = $this->items;

        shuffle($items);

        return new static($items);
    }

    /**
     * Creates a collection with items in reverse order
     *
     * @param bool $preserveKeys Whether to preserve keys
     *
     * @return ArrayCollection
     */
    public function reverse(bool $preserveKeys = false): ArrayCollection
    {
        return new static(array_reverse($this->items, $preserveKeys));
    }

    /**
     * Creates a sorted collection
     *
     * Comparator signature:
     *
     * <code>
     * function ($a, $b): int {}
     * </code>
     *
     * @param callable|null $comparator The comparator function
     *
     * @return ArrayCollection
     */
    public function sort(callable $comparator = null): ArrayCollection
    {
        $items = $this->items;

        $comparator ? uasort($items, $comparator) : uasort($items, function ($a, $b) {
            return $a <=> $b;
        });

        return new static($items);
    }

    /**
     * Creates a sorted collection using values from a callback
     *
     * Callback function should return a value for comparison
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback   The callback function
     * @param int      $options    The sort options
     * @param bool     $descending Whether to sort in descending order
     *
     * @return ArrayCollection
     */
    public function sortBy(callable $callback, $options = SORT_REGULAR, $descending = false): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $items[$key] = $callback($value, $key);
        }

        if ($descending) {
            arsort($items, $options);
        } else {
            asort($items, $options);
        }

        foreach (array_keys($items) as $key) {
            $items[$key] = $this->items[$key];
        }

        return new static($items);
    }

    /**
     * Creates a descending sorted collection using values from a callback
     *
     * Callback function should return a value for comparison
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback The callback function
     * @param int      $options  The sort options
     *
     * @return ArrayCollection
     */
    public function sortByDesc(callable $callback, $options = SORT_REGULAR): ArrayCollection
    {
        return $this->sortBy($callback, $options, true);
    }

    /**
     * Pipes the collection through a callback function
     *
     * Callback signature:
     *
     * <code>
     * function (ArrayCollection $collection): ArrayCollection {}
     * </code>
     *
     * @param callable $callback The callback function
     *
     * @return ArrayCollection
     */
    public function pipe(callable $callback): ArrayCollection
    {
        return $callback($this);
    }

    /**
     * Applies a callback function to every item
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): void {}
     * </code>
     *
     * @param callable $callback The callback function
     *
     * @return ArrayCollection
     */
    public function each(callable $callback): ArrayCollection
    {
        foreach ($this->items as $key => $value) {
            $callback($value, $key);
        }

        return $this;
    }

    /**
     * Creates a collection from the results of a callback function
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback The callback function
     *
     * @return ArrayCollection
     */
    public function map(callable $callback): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $items[$key] = $callback($value, $key);
        }

        return new static($items);
    }

    /**
     * Creates a collection of values with a given key
     *
     * @param string $key The key
     *
     * @return ArrayCollection
     */
    public function pluck(string $key): ArrayCollection
    {
        return $this->map(function ($value) use ($key) {
            return $value[$key] ?? null;
        });
    }

    /**
     * Creates a collection keyed by keys from a callback
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback The callback function
     *
     * @return ArrayCollection
     */
    public function keyBy(callable $callback): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $items[$callback($value, $key)] = $value;
        }

        return new static($items);
    }

    /**
     * Creates a collection grouped by keys from a callback
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback     The callback function
     * @param bool     $preserveKeys Whether to preserve keys
     *
     * @return ArrayCollection
     */
    public function groupBy(callable $callback, bool $preserveKeys = false): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $group = $callback($value, $key);

            if (!array_key_exists($group, $items)) {
                $items[$group] = new static();
            }

            $items[$group]->set($preserveKeys ? $key : null, $value);
        }

        return new static($items);
    }

    /**
     * Creates a collection where rows and columns are transposed
     *
     * @return ArrayCollection
     */
    public function transpose(): ArrayCollection
    {
        $items = array_map(function (...$items) {
            return $items;
        }, ...$this->values());

        return new static($items);
    }

    /**
     * Creates a collection with item chunks
     *
     * @param int  $size         The chunk size
     * @param bool $preserveKeys Whether to preserve keys
     *
     * @return ArrayCollection
     */
    public function chunk(int $size, bool $preserveKeys = false): ArrayCollection
    {
        $chunks = [];

        foreach (array_chunk($this->items, $size, $preserveKeys) as $chunk) {
            $chunks[] = new static($chunk);
        }

        return new static($chunks);
    }

    /**
     * Creates a collection flattened into a single level
     *
     * @param int $depth The depth to flatten
     *
     * @return ArrayCollection
     */
    public function flatten(int $depth = PHP_INT_MAX): ArrayCollection
    {
        return new static(static::flattenArray($this->items, $depth));
    }

    /**
     * Creates a mapped collection that is flattened by a single level
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable $callback The callback
     *
     * @return ArrayCollection
     */
    public function flatMap(callable $callback): ArrayCollection
    {
        return $this->map($callback)->collapse();
    }

    /**
     * Creates a collection with items collapsed
     *
     * @return ArrayCollection
     */
    public function collapse(): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $values) {
            if ($values instanceof self) {
                $values = $values->all();
            } elseif (!is_array($values)) {
                continue;
            }
            $items = array_merge($items, $values);
        }

        return new static($items);
    }

    /**
     * Creates a collection combining items as keys for given values
     *
     * @param mixed $values The values
     *
     * @return ArrayCollection
     */
    public function combine($values): ArrayCollection
    {
        return new static(array_combine($this->items, $this->itemsArray($values)));
    }

    /**
     * Creates a collection of two collections as keys and values
     *
     * @return ArrayCollection
     */
    public function divide(): ArrayCollection
    {
        return new static([$this->keys(), $this->values()]);
    }

    /**
     * Creates a collection zipped with the given items
     *
     * @param mixed ...$items The items
     *
     * @return ArrayCollection
     */
    public function zip(...$items): ArrayCollection
    {
        $arrayItems = array_map(function ($items) {
            return $this->itemsArray($items);
        }, $items);

        $params = array_merge([function (...$items) {
            return new static($items);
        }, $this->items], $arrayItems);

        return new static(call_user_func_array('array_map', $params));
    }

    /**
     * Creates a collection with unique items
     *
     * Optional callback should return a string value for equality comparison.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): string {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return ArrayCollection
     */
    public function unique(?callable $callback = null): ArrayCollection
    {
        if ($callback === null) {
            return new static(array_unique($this->items, SORT_REGULAR));
        }
        $set = [];

        return $this->filter(function ($value, $key) use ($callback, &$set) {
            $hash = $callback($value, $key);
            if (isset($set[$hash])) {
                return false;
            }
            $set[$hash] = true;

            return true;
        });
    }

    /**
     * Creates a collection with items that intersect with the given items
     *
     * @param mixed $items The items
     *
     * @return ArrayCollection
     */
    public function intersect($items): ArrayCollection
    {
        return new static(array_intersect($this->items, $this->itemsArray($items)));
    }

    /**
     * Creates a collection with items that are not present in the given items
     *
     * @param mixed $items The items
     *
     * @return ArrayCollection
     */
    public function diff($items): ArrayCollection
    {
        return new static(array_diff($this->items, $this->itemsArray($items)));
    }

    /**
     * Creates a collection with keys that are not present in the given items
     *
     * @param mixed $items The items
     *
     * @return ArrayCollection
     */
    public function diffKeys($items): ArrayCollection
    {
        return new static(array_diff_key($this->items, $this->itemsArray($items)));
    }

    /**
     * Creates a collection with the union of current and given items
     *
     * @param mixed $items The items
     *
     * @return ArrayCollection
     */
    public function union($items): ArrayCollection
    {
        return new static(array_unique(array_merge($this->items, $this->itemsArray($items))));
    }

    /**
     * Creates a collection with the given items merged
     *
     * @param mixed $items The items
     *
     * @return ArrayCollection
     */
    public function merge($items): ArrayCollection
    {
        return new static(array_merge($this->items, $this->itemsArray($items)));
    }

    /**
     * Creates a collection from items that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ArrayCollection
     */
    public function filter(callable $predicate): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            if ($predicate($value, $key)) {
                $items[$key] = $value;
            }
        }

        return new static($items);
    }

    /**
     * Creates a collection from items that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ArrayCollection
     */
    public function reject(callable $predicate): ArrayCollection
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            if (!$predicate($value, $key)) {
                $items[$key] = $value;
            }
        }

        return new static($items);
    }

    /**
     * Creates a filtered collection by key and value
     *
     * @param mixed $key    The key
     * @param mixed $value  The value
     * @param bool  $strict Whether comparison should be strict
     *
     * @return ArrayCollection
     */
    public function where($key, $value, bool $strict = true): ArrayCollection
    {
        return $this->filter(function ($item) use ($key, $value, $strict) {
            if (!isset($item[$key])) {
                return false;
            }

            return $strict ? $item[$key] === $value : $item[$key] == $value;
        });
    }

    /**
     * Creates a filtered collection by key and values
     *
     * @param mixed $key    The key
     * @param array $values The values
     * @param bool  $strict Whether comparison should be strict
     *
     * @return ArrayCollection
     */
    public function whereIn($key, array $values, bool $strict = true): ArrayCollection
    {
        return $this->filter(function ($item) use ($key, $values, $strict) {
            if (!isset($item[$key])) {
                return false;
            }

            return in_array($item[$key], $values, $strict);
        });
    }

    /**
     * Creates a collection from a slice of items
     *
     * @param int      $offset The starting offset
     * @param int|null $length The length or null for remaining
     *
     * @return ArrayCollection
     */
    public function slice(int $offset, ?int $length = null): ArrayCollection
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Creates a collection with the first or last {$limit} items
     *
     * Returns items from the end of the collection when limit is negative.
     *
     * @param int $limit The limit
     *
     * @return ArrayCollection
     */
    public function take(int $limit): ArrayCollection
    {
        if ($limit < 0) {
            return $this->slice($limit, (int) abs($limit));
        }

        return $this->slice(0, $limit);
    }

    /**
     * Creates a collection with every n-th element
     *
     * @param int $step The step number
     *
     * @return ArrayCollection
     */
    public function skip(int $step): ArrayCollection
    {
        $items = [];
        $pos = 0;

        foreach ($this->items as $key => $value) {
            if ($pos % $step === 0) {
                $items[$key] = $value;
            }
            $pos++;
        }

        return new static($items);
    }

    /**
     * Creates a collection with every other (even) element
     *
     * @return ArrayCollection
     */
    public function even(): ArrayCollection
    {
        $items = [];
        $pos = 0;

        foreach ($this->items as $key => $value) {
            if ($pos % 2 === 0) {
                $items[$key] = $value;
            }
            $pos++;
        }

        return new static($items);
    }

    /**
     * Creates a collection with every other (odd) element
     *
     * @return ArrayCollection
     */
    public function odd(): ArrayCollection
    {
        $items = [];
        $pos = 0;

        foreach ($this->items as $key => $value) {
            if ($pos % 2 === 1) {
                $items[$key] = $value;
            }
            $pos++;
        }

        return new static($items);
    }

    /**
     * Creates a collection of two collections based on a truth test
     *
     * Items that pass the truth test are placed in the first collection.
     *
     * Items that fail the truth test are placed in the second collection.
     *
     * Predicate signature:
     *
     * <code>
     * function ($value, $key): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ArrayCollection
     */
    public function partition(callable $predicate): ArrayCollection
    {
        $items1 = [];
        $items2 = [];

        foreach ($this->items as $key => $value) {
            if ($predicate($value, $key)) {
                $items1[$key] = $value;
            } else {
                $items2[$key] = $value;
            }
        }

        return new static([new static($items1), new static($items2)]);
    }

    /**
     * Creates a paginated collection
     *
     * @param int $page    The page number
     * @param int $perPage The number of items per page
     *
     * @return ArrayCollection
     */
    public function page(int $page, int $perPage): ArrayCollection
    {
        return $this->slice(($page - 1) * $perPage, $perPage);
    }

    /**
     * Concatenates values into a string
     *
     * Optional callback should return a string value for concatenation.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): string {}
     * </code>
     *
     * @param string|null   $glue     The string to join around
     * @param callable|null $callback The callback function
     *
     * @return string
     */
    public function implode(?string $glue = null, ?callable $callback = null): string
    {
        if ($glue === null) {
            $glue = '';
        }

        if ($callback !== null) {
            return implode($glue, $this->map($callback)->all());
        }

        return implode($glue, $this->all());
    }

    /**
     * Alias for implode
     *
     * Optional callback should return a string value for concatenation.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): string {}
     * </code>
     *
     * @param string|null   $glue     The string to join around
     * @param callable|null $callback The callback function
     *
     * @return string
     */
    public function join(?string $glue = null, ?callable $callback = null): string
    {
        return $this->implode($glue, $callback);
    }

    /**
     * Reduces the collection to a single value
     *
     * The callback must return the accumulator.
     *
     * Callback signature:
     *
     * <code>
     * function ($accumulator, $value, $key): mixed {}
     * </code>
     *
     * @param callable $callback The callback function
     * @param mixed    $initial  The initial value
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        $accumulator = $initial;

        foreach ($this->items as $key => $value) {
            $accumulator = $callback($accumulator, $value, $key);
        }

        return $accumulator;
    }

    /**
     * Retrieves the sum of the collection
     *
     * The callback should return a value to sum.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return mixed
     */
    public function sum(?callable $callback = null)
    {
        if ($callback === null) {
            $callback = function ($value) {
                return $value;
            };
        }

        return $this->reduce(function ($total, $value, $key) use ($callback) {
            return $total + $callback($value, $key);
        }, 0);
    }

    /**
     * Retrieves the average of the collection
     *
     * The callback should return a value to sum.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return mixed
     */
    public function avg(?callable $callback = null)
    {
        if ($this->isEmpty()) {
            return null;
        }
        $count = $this->count();

        return $this->sum($callback) / $count;
    }

    /**
     * Alias for avg
     *
     * The callback should return a value to sum.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return mixed
     */
    public function average(?callable $callback = null)
    {
        return $this->avg($callback);
    }

    /**
     * Retrieves the maximum value for a collection
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return mixed
     */
    public function max(?callable $callback = null)
    {
        return $this->reduce(function ($result, $value, $key) use ($callback) {
            if ($callback !== null) {
                $value = $callback($value, $key);
            }

            return ($result === null) || $value > $result ? $value : $result;
        });
    }

    /**
     * Retrieves the minimum value for a collection
     *
     * The callback should return a value to compare.
     *
     * Callback signature:
     *
     * <code>
     * function ($value, $key): mixed {}
     * </code>
     *
     * @param callable|null $callback The callback function
     *
     * @return mixed
     */
    public function min(?callable $callback = null)
    {
        return $this->reduce(function ($result, $value, $key) use ($callback) {
            if ($callback !== null) {
                $value = $callback($value, $key);
            }

            return ($result === null) || $value < $result ? $value : $result;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->items);
    }

    /**
     * Retrieves a JSON representation
     *
     * @param int $options Bitmask options for JSON encode
     *
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Retrieves a value for JSON encoding
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Handles casting to a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * Retrieves an iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Flattens a multi-dimensional array into a single level
     *
     * @param array $array The array
     * @param int   $depth The depth
     *
     * @return array
     */
    protected static function flattenArray(array $array, int $depth = PHP_INT_MAX): array
    {
        $items = [];

        foreach ($array as $item) {
            if ($item instanceof self) {
                $item = $item->all();
            }

            if (is_array($item)) {
                if ($depth === 1) {
                    $items = array_merge($items, $item);
                    continue;
                }
                $items = array_merge($items, static::flattenArray($item, $depth - 1));
                continue;
            }

            $items[] = $item;
        }

        return $items;
    }

    /**
     * Retrieves items as an array
     *
     * @codeCoverageIgnore
     *
     * @param mixed $items The items
     *
     * @return array
     */
    protected function itemsArray($items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        }

        return (array) $items;
    }
}
