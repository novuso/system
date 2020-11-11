<?php declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparator;

/**
 * Class FunctionComparator
 */
final class FunctionComparator implements Comparator
{
    /**
     * Constructs FunctionComparator
     */
    public function __construct(protected callable $function) {}

    /**
     * @inheritDoc
     */
    public function compare(mixed $object1, mixed $object2): int
    {
        return (int) call_user_func($this->function, $object1, $object2);
    }
}
