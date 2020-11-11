<?php declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;

/**
 * Class IntegerComparator
 */
final class IntegerComparator implements Comparator
{
    /**
     * @inheritDoc
     */
    public function compare(mixed $object1, mixed $object2): int
    {
        Assert::isInt($object1);
        Assert::isInt($object2);

        return $object1 <=> $object2;
    }
}
