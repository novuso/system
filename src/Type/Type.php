<?php

declare(strict_types=1);

namespace Novuso\System\Type;

use JsonSerializable;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Validate;

/**
 * Class Type
 */
final class Type implements Equatable, JsonSerializable
{
    /**
     * Constructs Type
     *
     * @codeCoverageIgnore coverage bug
     *
     * @internal
     */
    protected function __construct(protected string $name)
    {
    }

    /**
     * Creates instance from an object or class name
     */
    public static function create(object|string $object): Type
    {
        return new static(ClassName::canonical($object));
    }

    /**
     * Retrieves the full class name
     */
    public function toClassName(): string
    {
        return ClassName::full($this->name);
    }

    /**
     * Retrieves a string representation
     */
    public function toString(): string
    {
        return $this->name;
    }

    /**
     * Handles casting to a string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Retrieves a value for JSON encoding
     */
    public function jsonSerialize(): string
    {
        return $this->name;
    }

    /**
     * Retrieves a representation to serialize
     */
    public function __serialize(): array
    {
        return ['name' => $this->name];
    }

    /**
     * Handles construction from serialized data
     */
    public function __unserialize(array $data): void
    {
        $this->name = $data['name'];
    }

    /**
     * @inheritDoc
     */
    public function equals(mixed $object): bool
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
     * @inheritDoc
     */
    public function hashValue(): string
    {
        return $this->name;
    }
}
