<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\ClassName;

/**
 * @covers \Novuso\System\Utility\ClassName
 */
class ClassNameTest extends UnitTestCase
{
    public function test_that_full_returns_fqcn_when_passed_fqcn()
    {
        $className = 'OnlineMedEd\\System\\Utility\\ClassName';

        static::assertSame($className, ClassName::full($className));
    }

    public function test_that_full_returns_fqcn_when_passed_object()
    {
        $className = static::class;

        static::assertSame($className, ClassName::full($this));
    }

    public function test_that_canonical_returns_expected_value()
    {
        $expected = 'OnlineMedEd.System.Utility.ClassName';
        $className = 'OnlineMedEd\\System\\Utility\\ClassName';

        static::assertSame($expected, ClassName::canonical($className));
    }

    public function test_that_underscore_returns_expected_value()
    {
        $expected = 'online_med_ed.system.utility.class_name';
        $className = 'OnlineMedEd\\System\\Utility\\ClassName';

        static::assertSame($expected, ClassName::underscore($className));
    }

    public function test_that_short_returns_expected_value()
    {
        $expected = 'ClassName';
        $className = 'OnlineMedEd\\System\\Utility\\ClassName';

        static::assertSame($expected, ClassName::short($className));
    }
}
