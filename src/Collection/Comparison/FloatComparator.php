<?php declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;

/**
 * Class FloatComparator
 */
final class FloatComparator implements Comparator
{
    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        Assert::isFloat($object1);
        Assert::isFloat($object2);

        return $object1 <=> $object2;
    }
}
