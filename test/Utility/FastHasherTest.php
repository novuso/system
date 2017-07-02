<?php

namespace Novuso\Test\System\Utility;

use Novuso\System\Utility\FastHasher;
use Novuso\Test\System\Resources\StringObject;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Utility\FastHasher
 */
class FastHasherTest extends UnitTestCase
{
    const HASH_ALGO = 'fnv1a32';

    public function test_that_hash_returns_expected_value_for_null()
    {
        $expected = '350ca8af';
        $this->assertSame($expected, FastHasher::hash(null, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_true()
    {
        $expected = 'ba3db26d';
        $this->assertSame($expected, FastHasher::hash(true, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_false()
    {
        $expected = 'b93db0da';
        $this->assertSame($expected, FastHasher::hash(false, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_std_class()
    {
        $object = new \StdClass();
        $objHash = spl_object_hash($object);
        $expected = hash(static::HASH_ALGO, sprintf('o_%s', $objHash));
        $this->assertSame($expected, FastHasher::hash($object, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_equatable()
    {
        $string = 'Hello World';
        $expected = hash(static::HASH_ALGO, sprintf('e_%s', $string));
        $this->assertSame($expected, FastHasher::hash(new StringObject($string), static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_string()
    {
        $expected = '8dffd835';
        $this->assertSame($expected, FastHasher::hash('Hello World', static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_integer()
    {
        $expected = '0ad1d667';
        $this->assertSame($expected, FastHasher::hash(42, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_float()
    {
        $expected = '82fbd3a2';
        $this->assertSame($expected, FastHasher::hash(3.14, static::HASH_ALGO));
    }

    public function test_that_hash_returns_expected_value_for_resource()
    {
        $handle = fopen(__FILE__, 'r');
        $expected = hash(static::HASH_ALGO, sprintf('r_%d', (int) $handle));
        $this->assertSame($expected, FastHasher::hash($handle, static::HASH_ALGO));
        fclose($handle);
    }

    public function test_that_hash_returns_expected_value_for_array()
    {
        $expected = '9568b1b3';
        $this->assertSame($expected, FastHasher::hash(['foo', 'bar', 'baz'], static::HASH_ALGO));
    }
}
