<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Contract;

use Countable;
use IteratorAggregate;

/**
 * Interface Collection
 */
interface Collection extends Countable, IteratorAggregate
{
    /**
     * Checks if empty
     */
    public function isEmpty(): bool;
}
