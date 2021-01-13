<?php

declare(strict_types=1);

namespace Novuso\System\Test\TestCase;

use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * Class UnitTestCase
 */
abstract class UnitTestCase extends TestCase
{
    use MockObjects;
    use VirtualFileSystem;

    /**
     * Handles clean-up after tests
     */
    protected function tearDown(): void
    {
        $reflection = new ReflectionObject($this);

        foreach ($reflection->getProperties() as $prop) {
            if (
                !$prop->isStatic()
                && str_starts_with($prop->getDeclaringClass()->getName(), 'PHPUnit')
            ) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        $container = Mockery::getContainer();

        if ($container) {
            $this->addToAssertionCount(
                $container->mockery_getExpectationCount()
            );
        }

        Mockery::close();
    }
}
