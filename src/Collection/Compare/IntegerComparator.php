<?php declare(strict_types=1);

namespace Novuso\System\Collection\Compare;

use Novuso\System\Type\Comparator;

/**
 * IntegerComparator compares integer values for sorting
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class IntegerComparator implements Comparator
{
    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        assert(
            is_int($object1) && is_int($object2),
            'Comparison requires two integers'
        );

        return $object1 <=> $object2;
    }
}
