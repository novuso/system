<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparable;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\Assert;

/**
 * Class ComparableComparator
 */
final class ComparableComparator implements Comparator
{
    /**
     * @inheritDoc
     */
    public function compare(mixed $object1, mixed $object2): int
    {
        /** @var Comparable $object1 */
        Assert::isInstanceOf($object1, Comparable::class);

        return $object1->compareTo($object2);
    }
}
