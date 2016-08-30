<?php

namespace Novuso\Test\System\Resources;

use JsonSerializable;
use Novuso\System\Exception\TypeException;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use Novuso\System\Utility\Validate;
use Serializable;

final class IntegerObject implements Comparable, Equatable, JsonSerializable, Serializable
{
    protected $value;

    public function __construct($value)
    {
        if (!is_int($value)) {
            $message = sprintf('%s expects value to be an integer; received %s', __METHOD__, gettype($value));
            throw new TypeException($message);
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function equals($object): bool
    {
        if ($this === $object) {
            return true;
        }

        if (!Validate::areSameType($this, $object)) {
            return false;
        }

        return $this->value() === $object->value();
    }

    public function compareTo($object): int
    {
        if ($this === $object) {
            return 0;
        }

        assert(
            Validate::areSameType($this, $object),
            sprintf('Comparison requires instance of %s', static::class)
        );

        $thisVal = $this->value();
        $thatVal = $object->value();

        if ($thisVal > $thatVal) {
            return 1;
        }
        if ($thisVal < $thatVal) {
            return -1;
        }

        return 0;
    }

    public function hashValue(): string
    {
        return (string) $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public function serialize(): string
    {
        return serialize(['value' => $this->value]);
    }

    public function unserialize($str)
    {
        $data = unserialize($str);
        $this->__construct($data['value']);
    }
}
