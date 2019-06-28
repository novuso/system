<?php declare(strict_types=1);

namespace Novuso\System\Collection\Iterator;

use Generator;
use Iterator;
use Novuso\System\Exception\MethodCallException;
use Throwable;

/**
 * Class GeneratorIterator
 */
final class GeneratorIterator implements Iterator
{
    /**
     * Generator function
     *
     * @var callable
     */
    protected $function;

    /**
     * Function arguments
     *
     * @var array
     */
    protected $args;

    /**
     * Generator instance
     *
     * @var Generator|null
     */
    protected $generator;

    /**
     * Constructs GeneratorIterator
     *
     * @param callable $function The generator function
     * @param array    $args     The function arguments
     */
    public function __construct(callable $function, array $args = [])
    {
        $this->function = $function;
        $this->args = $args;
        $this->generator = null;
    }

    /**
     * Rewinds the iterator
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->generator = call_user_func_array($this->function, $this->args);
    }

    /**
     * Checks if position is valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        if (!$this->generator) {
            $this->rewind();
        }

        return $this->generator->valid();
    }

    /**
     * Retrieves the yielded value
     *
     * @return mixed
     */
    public function current()
    {
        if (!$this->generator) {
            $this->rewind();
        }

        return $this->generator->current();
    }

    /**
     * Retrieves the yielded key
     *
     * @return mixed
     */
    public function key()
    {
        if (!$this->generator) {
            $this->rewind();
        }

        return $this->generator->key();
    }

    /**
     * Moves to the next position
     *
     * @return void
     */
    public function next(): void
    {
        if (!$this->generator) {
            $this->rewind();
        }

        $this->generator->next();
    }

    /**
     * Sends a value to the generator
     *
     * Sends the given value to the generator as the result of the current
     * yield expression and resumes execution of the generator.
     *
     * If the generator is not at a yield expression when this method is
     * called, it will first be let to advance to the first yield expression
     * before sending the value. As such it is not necessary to "prime" PHP
     * generators with a Generator::next() call (like it is done in Python).
     *
     * @param mixed $value The value
     *
     * @return mixed
     */
    public function send($value = null)
    {
        if (!$this->generator) {
            $this->rewind();
        }

        return $this->generator->send($value);
    }

    /**
     * Handles undefined method calls
     *
     * Needed to support throw method, which is a reserved word.
     *
     * @param string $method The method name
     * @param array  $args   The method arguments
     *
     * @return mixed
     *
     * @throws Throwable When exception is thrown by called method
     * @throws MethodCallException When the method is invalid
     */
    public function __call($method, array $args)
    {
        if ($method === 'throw') {
            if (!$this->generator) {
                $this->rewind();
            }

            return call_user_func_array([$this->generator, 'throw'], $args);
        } else {
            $message = sprintf('Call to undefined method GeneratorIterator::%s()', $method);
            throw new MethodCallException($message);
        }
    }
}
