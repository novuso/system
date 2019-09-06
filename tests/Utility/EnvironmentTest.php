<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Utility\Environment;

/**
 * @covers \Novuso\System\Utility\Environment
 */
class EnvironmentTest extends UnitTestCase
{
    public function test_that_default_value_is_returned_when_env_is_not_present()
    {
        $this->assertSame('default', Environment::get('TEST_ENV_MISSING', 'default'));
    }

    public function test_that_true_is_returned_when_env_is_true()
    {
        putenv('TEST_ENV=true');
        $this->assertTrue(Environment::get('TEST_ENV'));
    }

    public function test_that_true_is_returned_when_env_is_true_with_paren()
    {
        putenv('TEST_ENV=(true)');
        $this->assertTrue(Environment::get('TEST_ENV'));
    }

    public function test_that_false_is_returned_when_env_is_false()
    {
        putenv('TEST_ENV=false');
        $this->assertFalse(Environment::get('TEST_ENV'));
    }

    public function test_that_false_is_returned_when_env_is_false_with_paren()
    {
        putenv('TEST_ENV=(false)');
        $this->assertFalse(Environment::get('TEST_ENV'));
    }

    public function test_that_empty_string_is_returned_when_env_is_empty()
    {
        putenv('TEST_ENV=empty');
        $this->assertSame('', Environment::get('TEST_ENV'));
    }

    public function test_that_empty_string_is_returned_when_env_is_empty_with_paren()
    {
        putenv('TEST_ENV=(empty)');
        $this->assertSame('', Environment::get('TEST_ENV'));
    }

    public function test_that_null_is_returned_when_env_is_null()
    {
        putenv('TEST_ENV=null');
        $this->assertNull(Environment::get('TEST_ENV'));
    }

    public function test_that_null_is_returned_when_env_is_null_with_paren()
    {
        putenv('TEST_ENV=(null)');
        $this->assertNull(Environment::get('TEST_ENV'));
    }

    public function test_that_string_is_returned_when_env_contains_basic_string()
    {
        putenv('TEST_ENV=foo');
        $this->assertSame('foo', Environment::get('TEST_ENV'));
    }

    public function test_that_string_is_returned_when_env_contains_quoted_string()
    {
        putenv('TEST_ENV="foo"');
        $this->assertSame('foo', Environment::get('TEST_ENV'));
    }
}
