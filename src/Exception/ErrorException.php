<?php declare(strict_types=1);

namespace Novuso\System\Exception;

use Throwable;

/**
 * Class ErrorException
 */
class ErrorException extends RuntimeException
{
    /**
     * Errors
     *
     * @var array
     */
    protected $errors;

    /**
     * Constructs ErrorException
     *
     * @param string         $message  The error message
     * @param array          $errors   The errors
     * @param int            $code     The error code
     * @param Throwable|null $previous The previous exception
     */
    public function __construct(string $message = '', array $errors = [], int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Retrieves the errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
