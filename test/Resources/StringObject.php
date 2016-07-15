<?php

namespace Novuso\Test\System\Resources;

use JsonSerializable;
use Novuso\System\Exception\TypeException;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use Novuso\System\Utility\Test;
use Serializable;

class StringObject implements Comparable, Equatable, JsonSerializable, Serializable
{
    protected $value;

    public function __construct($value)
    {
        if (!is_string($value)) {
            $message = sprintf('%s expects value to be a string; received %s', __METHOD__, gettype($value));
            throw new TypeException($message);
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function serialize()
    {
        return serialize(['value' => $this->value]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->__construct($data['value']);
    }

    public function compareTo($object): int
    {
        if ($this === $object) {
            return 0;
        }

        assert(
            Test::areSameType($this, $object),
            sprintf('Comparison requires instance of %s', static::class)
        );

        $comp = strnatcmp($this->value, $object->value);

        if ($comp > 0) {
            return 1;
        }
        if ($comp < 0) {
            return -1;
        }

        return 0;
    }

    public function equals($object): bool
    {
        if ($this === $object) {
            return true;
        }

        if (!Test::areSameType($this, $object)) {
            return false;
        }

        return $this->value === $object->value;
    }

    public function hashValue(): string
    {
        return $this->value;
    }
}
