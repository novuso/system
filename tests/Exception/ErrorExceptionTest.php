<?php

declare(strict_types=1);

namespace Novuso\System\Test\Exception;

use Novuso\System\Exception\ErrorException;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ErrorException::class)]
class ErrorExceptionTest extends UnitTestCase
{
    public function test_that_get_errors_returns_expected_value()
    {
        $message = 'Something went wrong';
        $errors = ['foo' => 'bar'];
        $exception = new ErrorException($message, $errors);

        static::assertSame($errors, $exception->getErrors());
    }
}
