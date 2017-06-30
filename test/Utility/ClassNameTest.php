<?php

namespace Novuso\Test\System\Utility;

use Novuso\System\Utility\ClassName;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Utility\ClassName
 */
class ClassNameTest extends UnitTestCase
{
    public function test_that_full_returns_fqcn_when_passed_fqcn()
    {
        $className = 'Novuso\\System\\Utility\\ClassName';
        $this->assertSame($className, ClassName::full($className));
    }

    public function test_that_full_returns_fqcn_when_passed_object()
    {
        $className = static::class;
        $this->assertSame($className, ClassName::full($this));
    }

    public function test_that_canonical_returns_expected_value()
    {
        $expected = 'Novuso.System.Utility.ClassName';
        $className = 'Novuso\\System\\Utility\\ClassName';
        $this->assertSame($expected, ClassName::canonical($className));
    }

    public function test_that_underscore_returns_expected_value()
    {
        $expected = 'novuso.system.utility.class_name';
        $className = 'Novuso\\System\\Utility\\ClassName';
        $this->assertSame($expected, ClassName::underscore($className));
    }

    public function test_that_short_returns_expected_value()
    {
        $expected = 'ClassName';
        $className = 'Novuso\\System\\Utility\\ClassName';
        $this->assertSame($expected, ClassName::short($className));
    }

    /**
     * @expectedException \Novuso\System\Exception\TypeException
     */
    public function test_that_full_throws_exception_for_invalid_argument_type()
    {
        ClassName::full(null);
    }
}
