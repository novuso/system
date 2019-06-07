<?php declare(strict_types=1);

namespace Novuso\System\Collection\Comparison;

use Novuso\System\Type\Comparator;

/**
 * Class FunctionComparator
 */
final class FunctionComparator implements Comparator
{
    /**
     * Callback function
     *
     * @var callable
     */
    protected $function;

    /**
     * Constructs FunctionComparator
     *
     * @param callable $function The callback function
     */
    public function __construct(callable $function)
    {
        $this->function = $function;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($object1, $object2): int
    {
        return (int) call_user_func($this->function, $object1, $object2);
    }
}
