<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Iterator;

use Exception;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Exception\MethodCallException;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Iterator\GeneratorIterator
 */
class GeneratorIteratorTest extends UnitTestCase
{
    public function test_that_rewind_allows_iteration_more_than_once()
    {
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });

        $count = 0;
        foreach ($iterator as $key => $value) {
            $count++;
        }

        $this->assertFalse($iterator->valid());

        foreach ($iterator as $key => $value) {
            $count++;
        }
    }

    public function test_that_valid_returns_true_with_valid_position()
    {
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });

        $this->assertTrue($iterator->valid());
    }

    public function test_that_current_returns_first_yielded_value()
    {
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });

        $this->assertSame(0, $iterator->current());
    }

    public function test_that_key_returns_first_yielded_key()
    {
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });

        $this->assertSame(0, $iterator->key());
    }

    public function test_that_next_advances_to_next_position()
    {
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });

        $iterator->next();

        $this->assertSame(1, $iterator->key());
    }

    public function test_that_send_injects_value_to_generator()
    {
        $iterator = new GeneratorIterator(function () {
            $buffer = '';
            while (true) {
                $buffer .= (yield $buffer);
            }
        });

        $iterator->send('Hello');
        $iterator->send(' ');
        $iterator->send('World');

        $this->assertSame('Hello World', $iterator->current());
    }

    public function test_that_throw_sends_an_exception_into_generator()
    {
        $iterator = new GeneratorIterator(function () {
            $buffer = '';
            while (true) {
                try {
                    $buffer .= (yield $buffer);
                } catch (Exception $e) {
                    $buffer .= $e->getMessage();
                }
            }
        });

        $iterator->throw(new Exception('Oops!'));
        $iterator->send(' ');
        $iterator->send('Hello');
        $iterator->send(' ');
        $iterator->send('World');

        $this->assertSame('Oops! Hello World', $iterator->current());
    }

    public function test_that_it_throws_exception_for_bad_method_call()
    {
        $this->expectException(MethodCallException::class);
        $iterator = new GeneratorIterator(function () {
            for ($i = 0; $i < 10; $i++) {
                yield $i => $i;
            }
        });
        $iterator->foo();
    }
}
