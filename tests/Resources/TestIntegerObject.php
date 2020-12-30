<?php

declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use JsonSerializable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;

/**
 * Class TestIntegerObject
 */
class TestIntegerObject implements Comparable, Equatable, JsonSerializable
{
    public function __construct(protected int $value) {}

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

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public function compareTo(mixed $object): int
    {
        if ($this === $object) {
            return 0;
        }

        Assert::areSameType($this, $object);

        return $this->value <=> $object->value;
    }

    public function equals(mixed $object): bool
    {
        if ($this === $object) {
            return true;
        }

        if (!Validate::areSameType($this, $object)) {
            return false;
        }

        return $this->value === $object->value;
    }

    public function hashValue(): string
    {
        return (string) $this->value;
    }
}
