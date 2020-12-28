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
     * @inheritDoc
     */
    public function compare(mixed $object1, mixed $object2): int
    {
        Assert::isFloat($object1);
        Assert::isFloat($object2);

        return $object1 <=> $object2;
    }
}
