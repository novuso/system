<?php declare(strict_types=1);

namespace Novuso\System\Test;

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
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $reflection = new ReflectionObject($this);

        foreach ($reflection->getProperties() as $prop) {
            if (!$prop->isStatic() && strpos($prop->getDeclaringClass()->getName(), 'PHPUnit') !== 0) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        $container = Mockery::getContainer();

        if ($container) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }
}
