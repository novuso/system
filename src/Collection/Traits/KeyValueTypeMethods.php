<?php declare(strict_types=1);

namespace Novuso\System\Collection\Traits;

use Novuso\System\Utility\VarPrinter;

/**
 * KeyValueTypeMethods provides type methods for key/value collections
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
trait KeyValueTypeMethods
{
    /**
     * Key type
     *
     * @var string|null
     */
    private $keyType;

    /**
     * Value type
     *
     * @var string|null
     */
    private $valueType;

    /**
     * Retrieves the key type
     *
     * Returns null if the key type is dynamic.
     *
     * @return string|null
     */
    public function keyType(): ?string
    {
        return $this->keyType;
    }

    /**
     * Retrieves the value type
     *
     * Returns null if the value type is dynamic.
     *
     * @return string|null
     */
    public function valueType(): ?string
    {
        return $this->valueType;
    }

    /**
     * Sets the key type
     *
     * If a type is not provided, the key type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $keyType The key type or null for dynamic type
     *
     * @return void
     */
    protected function setKeyType(?string $keyType = null): void
    {
        if ($keyType !== null) {
            $keyType = trim($keyType);
        }

        $this->keyType = $keyType;
    }

    /**
     * Sets the value type
     *
     * If a type is not provided, the value type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $valueType The value type or null for dynamic type
     *
     * @return void
     */
    protected function setValueType(?string $valueType = null): void
    {
        if ($valueType !== null) {
            $valueType = trim($valueType);
        }

        $this->valueType = $valueType;
    }

    /**
     * Retrieves the key type error message
     *
     * @param string $method The calling method
     * @param mixed  $key    The key
     *
     * @return string
     */
    protected function keyTypeError(string $method, $key): string
    {
        $keyType = is_object($key) ? get_class($key) : gettype($key);

        return sprintf(
            '%s::%s expects key type (%s); received (%s) %s',
            static::class,
            $method,
            $this->keyType(),
            $keyType,
            VarPrinter::toString($key)
        );
    }

    /**
     * Retrieves the value type error message
     *
     * @param string $method The calling method
     * @param mixed  $value  The value
     *
     * @return string
     */
    protected function valueTypeError(string $method, $value): string
    {
        $valueType = is_object($value) ? get_class($value) : gettype($value);

        return sprintf(
            '%s::%s expects value type (%s); received (%s) %s',
            static::class,
            $method,
            $this->valueType(),
            $valueType,
            VarPrinter::toString($value)
        );
    }
}
