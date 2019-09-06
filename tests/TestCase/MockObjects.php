<?php declare(strict_types=1);

namespace Novuso\System\Test\TestCase;

use Mockery;
use Mockery\MockInterface;

/**
 * Trait MockObjects
 */
trait MockObjects
{
    /**
     * Creates a mock object
     *
     * Arguments are passed as-is to Mockery::mock()
     *
     * @return MockInterface
     */
    protected function mock(): MockInterface
    {
        $args = func_get_args();

        return call_user_func_array([Mockery::getContainer(), 'mock'], $args);
    }
}
