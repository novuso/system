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
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Retrieves the number of elements
     *
     * @return int
     */
    public function count(): int;

    /**
     * Retrieves an iterator
     *
     * @return Traversable
     */
    public function getIterator();
}
