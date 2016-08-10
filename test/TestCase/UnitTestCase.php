<?php

namespace Novuso\Test\System\TestCase;

use Mockery;
use Novuso\Test\System\Traits\MockObjects;
use Novuso\Test\System\Traits\VirtualFileSystem;
use PHPUnit_Framework_TestCase;
use ReflectionObject;

/**
 * UnitTestCase is the base class for unit test cases
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class UnitTestCase extends PHPUnit_Framework_TestCase
{
    use MockObjects;
    use VirtualFileSystem;

    /**
     * Handles clean-up after tests
     *
     * @return void
     */
    protected function tearDown()
    {
        $reflection = new ReflectionObject($this);
        foreach ($reflection->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        Mockery::close();
    }
}
