<?php declare(strict_types=1);

namespace Novuso\System\Collection\Compare;

use Novuso\System\Type\Comparator;

/**
 * StringComparator compares string values for sorting
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class StringComparator implements Comparator
{
    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        assert(
            is_string($object1) && is_string($object2),
            'Comparison requires two strings'
        );

        $comp = strnatcmp($object1, $object2);

        return $comp <=> 0;
    }
}
