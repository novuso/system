<?php declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;

/**
 * Class StringComparator
 */
final class StringComparator implements Comparator
{
    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        Assert::isString($object1);
        Assert::isString($object2);

        $comp = strnatcmp($object1, $object2);

        return $comp <=> 0;
    }
}
