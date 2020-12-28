<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Exception\RuntimeException;
use Novuso\System\Test\Resources\TestStringObject;
use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\VarPrinter;

/**
 * @covers \Novuso\System\Utility\VarPrinter
 */
class VarPrinterTest extends UnitTestCase
{
    public function test_that_to_string_returns_expected_string_for_null()
    {
        $expected = 'NULL';

        static::assertSame($expected, VarPrinter::toString(null));
    }

    public function test_that_to_string_returns_expected_string_for_true()
    {
        $expected = 'TRUE';

        static::assertSame($expected, VarPrinter::toString(true));
    }

    public function test_that_to_string_returns_expected_string_for_false()
    {
        $expected = 'FALSE';

        static::assertSame($expected, VarPrinter::toString(false));
    }

    public function test_that_to_string_returns_expected_string_for_std_class()
    {
        $expected = 'Object(stdClass)';
        $object = new \StdClass();

        static::assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_anon_function()
    {
        $expected = 'Function';
        $function = function () { };

        static::assertSame($expected, VarPrinter::toString($function));
    }

    public function test_that_to_string_returns_expected_string_for_datetime()
    {
        $expected = 'DateTime(2015-01-01T00:00:00+00:00)';
        $dateTime = new \DateTime('2015-01-01', new \DateTimeZone('UTC'));

        static::assertSame($expected, VarPrinter::toString($dateTime));
    }

    public function test_that_to_string_returns_expected_string_for_cast_object()
    {
        $expected = __FILE__;
        $object = new \SplFileInfo(__FILE__);

        static::assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_object_to_string()
    {
        $expected = 'Hello World';
        $object = new TestStringObject('Hello World');

        static::assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_exception()
    {
        $line = __LINE__ + 1;
        $object = new RuntimeException('Something went wrong', 31337);
        $expected = sprintf('RuntimeException(%s)', json_encode([
            'message' => 'Something went wrong',
            'code'    => 31337,
            'file'    => __FILE__,
            'line'    => $line
        ], JSON_UNESCAPED_SLASHES));

        static::assertSame($expected, VarPrinter::toString($object));
    }

    public function test_that_to_string_returns_expected_string_for_simple_array()
    {
        $expected = 'Array(0 => foo, 1 => bar, 2 => baz)';
        $data = ['foo', 'bar', 'baz'];

        static::assertSame($expected, VarPrinter::toString($data));
    }

    public function test_that_to_string_returns_expected_string_for_assoc_array()
    {
        $expected = 'Array(foo => bar)';
        $data = ['foo' => 'bar'];

        static::assertSame($expected, VarPrinter::toString($data));
    }

    public function test_that_to_string_returns_expected_string_for_resource()
    {
        $resource = fopen(__FILE__, 'r');
        $expected = sprintf('Resource(%d:stream)', get_resource_id($resource));

        static::assertSame($expected, VarPrinter::toString($resource));

        fclose($resource);
    }
}
