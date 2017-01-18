<?php declare(strict_types=1);

namespace Novuso\System\Type;

use JsonSerializable;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Validate;
use Serializable;

/**
 * Type is an object type description
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class Type implements Equatable, JsonSerializable, Serializable
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
     * @param string $name The type name
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
     */
    public static function create($object): Type
    {
        return new static(ClassName::canonical($object));
    }

    /**
     * Retrieves the full class name
     *
     * @return string
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
    public function jsonSerialize()
    {
        return $this->name;
    }

    /**
     * Retrieves a serialized representation
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(['name' => $this->name]);
    }

    /**
     * Handles construction from a serialized representation
     *
     * @param string $serialized The serialized representation
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->__construct($data['name']);
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
