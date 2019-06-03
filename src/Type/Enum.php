<?php declare(strict_types=1);

namespace Novuso\System\Type;

use Exception;
use JsonSerializable;
use Novuso\System\Exception\DomainException;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Validate;
use Novuso\System\Utility\VarPrinter;
use ReflectionClass;
use Serializable;

/**
 * Class Enum
 */
abstract class Enum implements Comparable, Equatable, JsonSerializable, Serializable
{
    /**
     * Constants cache
     *
     * @var array
     */
    private static $constants = [];

    /**
     * Enum value
     *
     * @var mixed
     */
    private $value;

    /**
     * Enum constant name
     *
     * @var string
     */
    private $name;

    /**
     * Enum constant ordinal
     *
     * @var int
     */
    private $ordinal;

    /**
     * Constructs Enum
     *
     * @internal
     *
     * @param mixed $value The enum value
     *
     * @throws DomainException When the value is invalid
     */
    final private function __construct($value)
    {
        $constants = self::getMembers();

        if (!in_array($value, $constants, true)) {
            $var = VarPrinter::toString($value);
            $message = sprintf('%s is not a member value of enum %s', $var, static::class);
            throw new DomainException($message);
        }

        $this->value = $value;
    }

    /**
     * Creates instance from an enum constant name
     *
     * Maps static method `MyClass::CONST_NAME()` given `CONST_NAME` is a class
     * constant of `MyClass`.
     *
     * @param string $name      The name of the method
     * @param array  $arguments A list of arguments
     *
     * @return static
     *
     * @throws DomainException When the constant name is not defined
     */
    final public static function __callStatic($name, $arguments)
    {
        return self::fromName($name);
    }

    /**
     * Creates instance from an enum constant value
     *
     * @param mixed $value The enum constant value
     *
     * @return static
     *
     * @throws DomainException When the value is invalid
     */
    final public static function fromValue($value)
    {
        return new static($value);
    }

    /**
     * Creates instance from a string representation
     *
     * @param string $string The string representation
     *
     * @return static
     *
     * @throws DomainException When the string is invalid
     */
    final public static function fromString(string $string)
    {
        $parts = explode('::', $string);

        return self::fromName(end($parts));
    }

    /**
     * Creates instance from an enum constant name
     *
     * @param string $name The enum constant name
     *
     * @return static
     *
     * @throws DomainException When the name is invalid
     */
    final public static function fromName(string $name)
    {
        $constName = sprintf('%s::%s', static::class, $name);

        if (!defined($constName)) {
            $message = sprintf('%s is not a member constant of enum %s', $name, static::class);
            throw new DomainException($message);
        }

        return new static(constant($constName));
    }

    /**
     * Creates instance from an enum ordinal position
     *
     * @param int $ordinal The enum ordinal position
     *
     * @return static
     *
     * @throws DomainException When the ordinal is invalid
     */
    final public static function fromOrdinal(int $ordinal)
    {
        $constants = self::getMembers();
        $item = array_slice($constants, $ordinal, 1, true);

        if (!$item) {
            $end = count($constants) - 1;
            $message = sprintf('Enum ordinal (%d) out of range [0, %d]', $ordinal, $end);
            throw new DomainException($message);
        }

        return new static(current($item));
    }

    /**
     * Retrieves enum member names and values
     *
     * @return array
     *
     * @throws DomainException When more than one constant has the same value
     */
    final public static function getMembers(): array
    {
        if (!isset(self::$constants[static::class])) {
            $reflection = new ReflectionClass(static::class);
            $constants = self::sortConstants($reflection);
            self::guardConstants($constants);
            self::$constants[static::class] = $constants;
        }

        return self::$constants[static::class];
    }

    /**
     * Retrieves the enum constant value
     *
     * @return mixed
     */
    final public function value()
    {
        return $this->value;
    }

    /**
     * Retrieves the enum constant name
     *
     * @return string
     *
     * @throws DomainException When more than one constant has the same value
     */
    final public function name(): string
    {
        if ($this->name === null) {
            $constants = self::getMembers();
            $this->name = array_search($this->value, $constants, true);
        }

        return $this->name;
    }

    /**
     * Retrieves the enum ordinal position
     *
     * @return int
     *
     * @throws Exception Will not happen
     */
    final public function ordinal(): int
    {
        if ($this->ordinal === null) {
            $ordinal = 0;
            foreach (self::getMembers() as $value) {
                if ($this->value === $value) {
                    break;
                }
                $ordinal++;
            }
            $this->ordinal = $ordinal;
        }

        return $this->ordinal;
    }

    /**
     * Retrieves a string representation
     *
     * @return string
     *
     * @throws Exception Will not happen
     */
    final public function toString(): string
    {
        return sprintf('%s::%s', ClassName::short(static::class), $this->name());
    }

    /**
     * Handles casting to a string
     *
     * @return string
     *
     * @throws Exception Will not happen
     */
    final public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Retrieves a value for JSON encoding
     *
     * @return mixed
     */
    final public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * Retrieves a representation to serialize
     *
     * @return array
     */
    final public function __serialize(): array
    {
        return ['value' => $this->value];
    }

    /**
     * Handles construction from serialized data
     *
     * @param array $data the serialized data
     *
     * @return void
     */
    final public function __unserialize(array $data): void
    {
        $this->value = $data['value'];
    }

    /**
     * Retrieves a serialized representation
     *
     * @return string
     */
    final public function serialize(): string
    {
        return serialize($this->__serialize());
    }

    /**
     * Handles construction from a serialized representation
     *
     * @param string $serialized The serialized representation
     *
     * @return void
     */
    final public function unserialize($serialized)
    {
        $this->__unserialize(unserialize($serialized));
    }

    /**
     * {@inheritdoc}
     */
    final public function compareTo($object): int
    {
        if ($this === $object) {
            return 0;
        }

        Assert::areSameType($this, $object);

        return $this->ordinal() <=> $object->ordinal();
    }

    /**
     * {@inheritdoc}
     */
    final public function equals($object): bool
    {
        if ($this === $object) {
            return true;
        }

        if (!Validate::areSameType($this, $object)) {
            return false;
        }

        return $this->name() === $object->name();
    }

    /**
     * {@inheritdoc}
     */
    final public function hashValue(): string
    {
        return $this->name();
    }

    /**
     * Validates enum constants
     *
     * @param array $constants The enum constants
     *
     * @return void
     *
     * @throws DomainException When more than one constant has the same value
     */
    final private static function guardConstants(array $constants): void
    {
        $duplicates = [];

        foreach ($constants as $value) {
            $names = array_keys($constants, $value, $strict = true);
            if (count($names) > 1) {
                $duplicates[VarPrinter::toString($value)] = $names;
            }
        }

        if (!empty($duplicates)) {
            $list = array_map(function ($names) use ($constants) {
                return sprintf('(%s)=%s', implode('|', $names), VarPrinter::toString($constants[$names[0]]));
            }, $duplicates);
            $message = sprintf('Duplicate enum values: %s', implode(', ', $list));
            throw new DomainException($message);
        }
    }

    /**
     * Sorts member constants
     *
     * @param ReflectionClass $reflection The reflection instance
     *
     * @return array
     */
    final private static function sortConstants(ReflectionClass $reflection): array
    {
        $constants = [];

        while ($reflection && __CLASS__ !== $reflection->getName()) {
            $scope = [];

            foreach ($reflection->getReflectionConstants() as $constant) {
                if ($constant->isPublic()) {
                    $scope[$constant->getName()] = $constant->getValue();
                }
            }

            $constants = $scope + $constants;
            $reflection = $reflection->getParentClass();
        }

        return $constants;
    }
}