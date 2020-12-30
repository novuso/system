<?php

declare(strict_types=1);

namespace Novuso\System\Type;

use Novuso\System\Exception\AssertionException;

/**
 * Interface Comparable
 */
interface Comparable
{
    /**
     * Compares to another object
     *
     * The passed object must be an instance of the same type.
     *
     * The method should return 0 for values considered equal, return -1 if
     * this instance is less than the passed value, and return 1 if this
     * instance is greater than the passed value.
     *
     * @throws AssertionException When the object type is not compatible
     */
    public function compareTo(mixed $object): int;
}
