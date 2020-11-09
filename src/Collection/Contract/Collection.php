<?php declare(strict_types=1);

namespace Novuso\System\Collection\Contract;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Interface Collection
 */
interface Collection extends Countable, IteratorAggregate
{
    /**
     * Checks if empty
     */
    public function isEmpty(): bool;

    /**
     * Retrieves the number of elements
     */
    public function count(): int;

    /**
     * Retrieves an iterator
     */
    public function getIterator(): Traversable;
}
