<?php declare(strict_types=1);

namespace Novuso\System\Collection\Traits;

/**
 * Trait KeyValueTypeMethods
 */
trait KeyValueTypeMethods
{
    private ?string $keyType;
    private ?string $valueType;

    /**
     * Retrieves the key type
     *
     * Returns null if the key type is dynamic.
     */
    public function keyType(): ?string
    {
        return $this->keyType;
    }

    /**
     * Retrieves the value type
     *
     * Returns null if the value type is dynamic.
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
     */
    protected function setKeyType(?string $keyType = null): void
    {
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
     */
    protected function setValueType(?string $valueType = null): void
    {
        $this->valueType = $valueType;
    }
}
