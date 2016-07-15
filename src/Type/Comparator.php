<?php declare(strict_types=1);

namespace Novuso\System\Type;

/**
 * Comparator is the interface for types that compare external values
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
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
     */
    public function compare($object1, $object2): int;
}
