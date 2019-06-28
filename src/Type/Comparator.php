<?php declare(strict_types=1);

namespace Novuso\System\Type;

use Novuso\System\Exception\AssertionException;

/**
 * Interface Comparator
 */
interface Comparator
{
    /**
     * Compares two values of compatible types
     *
     * The passed values must be a compatible type. The implementation may
     * determine what types are compatible, but this is most often restricted
     * to a single type.
     *
     * The method should return 0 for values considered equal, return -1 if
     * the first value is less than the second value, and return 1 if the
     * first value is greater than the second value.
     *
     * @param mixed $object1 The first object
     * @param mixed $object2 The second object
     *
     * @return int
     *
     * @throws AssertionException When the object types are not compatible
     */
    public function compare($object1, $object2): int;
}
