<?php declare(strict_types=1);

namespace Novuso\System\Type;

use JsonSerializable;
use Novuso\System\Exception\TypeException;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Validate;

/**
 * Class Type
 */
final class Type implements Equatable, JsonSerializable
{
    /**
     * Type name
     *
     * @var string
     */
    protected $name;

    /**
     * Constructs Type
     *
     * @internal
     *
     * @param string $name
     */
    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Creates instance from an object or class name
     *
     * @param object|string $object An object, fully qualified class name, or
     *                              canonical class name
     *
     * @return Type
     *
     * @throws TypeException When $object is not a string or object
     */
    public static function create($object): Type
    {
        return new static(ClassName::canonical($object));
    }

    /**
     * Retrieves the full class name
     *
     * @return string
     *
     * @throws TypeException Will not happen
     */
    public function toClassName(): string
    {
        return ClassName::full($this->name);
    }

    /**
     * Retrieves a string representation
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->name;
    }

    /**
     * Handles casting to a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Retrieves a value for JSON encoding
     *
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->name;
    }

    /**
     * Retrieves a representation to serialize
     *
     * @return array
     */
    public function __serialize(): array
    {
        return ['name' => $this->name];
    }

    /**
     * Handles construction from serialized data
     *
     * @param array $data the serialized data
     *
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->name = $data['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function equals($object): bool
    {
        if ($this === $object) {
            return true;
        }

        if (!Validate::areSameType($this, $object)) {
            return false;
        }

        return $this->name === $object->name;
    }

    /**
     * {@inheritdoc}
     */
    public function hashValue(): string
    {
        return $this->name;
    }
}
