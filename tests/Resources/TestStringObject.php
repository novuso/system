<?php declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use JsonSerializable;
use Novuso\System\Type\Comparable;
use Novuso\System\Type\Equatable;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\Validate;

/**
 * Class TestStringObject
 */
class TestStringObject implements Comparable, Equatable, JsonSerializable
{
    public function __construct(protected string $value) {}

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

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public function compareTo(mixed $object): int
    {
        if ($this === $object) {
            return 0;
        }

        Assert::areSameType($this, $object);

        $comp = strnatcmp($this->value, $object->value);

        return $comp <=> 0;
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
        return $this->value;
    }
}
