<?php

declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use Novuso\System\Exception\DomainException;
use Novuso\System\Serialization\Serializable;
use Novuso\System\Type\Comparable;
use Novuso\System\Utility\Assert;

/**
 * Class TestUser
 */
class TestUser implements Comparable, Serializable
{
    protected string $lastName;
    protected string $firstName;
    protected string $username;
    protected string $email;
    protected string $birthDate;

    public function __construct(array $data)
    {
        $this->lastName = $data['lastName'];
        $this->firstName = $data['firstName'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->birthDate = $data['birthDate'];
    }

    public static function arrayDeserialize(array $data): static
    {
        $keys = ['lastName', 'firstName', 'username', 'email', 'birthDate'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                $message = sprintf('Serialization key missing: %s', $key);
                throw new DomainException($message);
            }
        }

        return new static($data);
    }

    public function arraySerialize(): array
    {
        return $this->toArray();
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthDate(): string
    {
        return $this->birthDate;
    }

    public function toArray(): array
    {
        return [
            'lastName'  => $this->lastName,
            'firstName' => $this->firstName,
            'username'  => $this->username,
            'email'     => $this->email,
            'birthDate' => $this->birthDate
        ];
    }

    public function compareTo($object): int
    {
        if ($this === $object) {
            return 0;
        }

        Assert::areSameType($this, $object);

        $comp = strnatcmp($this->username(), $object->username());

        return $comp <=> 0;
    }
}
