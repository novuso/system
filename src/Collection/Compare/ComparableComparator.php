<?php declare(strict_types=1);

namespace Novuso\System\Collection\Compare;

use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;

/**
 * ComparableComparator compares object values for sorting
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ComparableComparator implements Comparator
{
    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        assert(
            ($object1 instanceof Comparable),
            'Comparison requires comparable objects'
        );

        return $object1->compareTo($object2);
    }
}
