<?php declare(strict_types=1);

namespace Novuso\System\Test\Exception;

use Novuso\System\Exception\ErrorException;
use Novuso\System\Test\UnitTestCase;

/**
 * @covers \Novuso\System\Exception\ErrorException
 */
class ErrorExceptionTest extends UnitTestCase
{
    public function test_that_it_contains_expected_errors()
    {
        $message = 'Validation Failed';
        $errors = [
            'username' => [
                'Username is required'
            ],
            'password' => [
                'Password must contain at least 1 special character',
                'Password must match confirm password field'
            ]
        ];

        $exception = new ErrorException($message, $errors);

        $this->assertSame($errors, $exception->getErrors());
    }
}
