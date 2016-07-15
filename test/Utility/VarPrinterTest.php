<?php

namespace Novuso\Test\System\Utility;

use Novuso\System\Utility\VarPrinter;
use Novuso\Test\System\Resources\StringObject;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Utility\VarPrinter
 */
class VarPrinterTest extends UnitTestCase
{
    public function test_that_to_string_returns_expected_string_for_null()
    {
        $expected = 'NULL';
        $this->assertSame($expected, VarPrinter::toString(null));
    }

    public function test_that_to_string_returns_expected_string_for_true()
    {
        $expected = 'TRUE';
        $this->assertSame($expected, VarPrinter::toString(true));
    }

    public function test_that_to_string_returns_expected_string_for_false()
    {
        $expected = 'FALSE';
        $this->assertSame($expected, VarPrinter::toString(false));
    }

    public function test_that_to_string_returns_expected_string_for_std_class()
    {
        $expected = 'Object(stdClass)';
        $object = new \StdClass();
        $this->assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_anon_function()
    {
        $expected = 'Function';
        $function = function () {};
        $this->assertSame($expected, VarPrinter::toString($function));
    }

    public function test_that_to_string_returns_expected_string_for_datetime()
    {
        $expected = 'DateTime(2015-01-01T00:00:00+00:00)';
        $dateTime = new \DateTime('2015-01-01', new \DateTimeZone('UTC'));
        $this->assertSame($expected, VarPrinter::toString($dateTime));
    }

    public function test_that_to_string_returns_expected_string_for_cast_object()
    {
        $expected = __FILE__;
        $object = new \SplFileInfo(__FILE__);
        $this->assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_object_to_string()
    {
        $expected = 'Hello World';
        $object = new StringObject('Hello World');
        $this->assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_simple_array()
    {
        $expected = 'Array(0 => foo, 1 => bar, 2 => baz)';
        $data = ['foo', 'bar', 'baz'];
        $this->assertSame($expected, VarPrinter::toString($data));
    }

    public function test_that_to_string_returns_expected_string_for_assoc_array()
    {
        $expected = 'Array(foo => bar)';
        $data = ['foo' => 'bar'];
        $this->assertSame($expected, VarPrinter::toString($data));
    }

    public function test_that_to_string_returns_expected_string_for_resource()
    {
        $expected = 'Resource(stream)';
        $resource = fopen(__FILE__, 'r');
        $this->assertSame($expected, VarPrinter::toString($resource));
        fclose($resource);
    }
}
