<?php declare(strict_types=1);

namespace Novuso\System\Collection\Mixin;

/**
 * Trait KeyValueTypeMethods
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
}
