<?php

namespace Novuso\Test\System\Traits;

use Mockery;
use Mockery\MockInterface;

trait MockObjects
{
    /**
     * Creates a mock object
     *
     * Arguments are passed as-is to Mockery::mock()
     *
     * @return MockInterface
     */
    protected function mock()
    {
        $args = func_get_args();

        return call_user_func_array([Mockery::getContainer(), 'mock'], $args);
    }
}
