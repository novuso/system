<?php

namespace Novuso\Test\System\Resources;

use Novuso\System\Type\Comparable;
use Novuso\System\Utility\Test;

class User implements Comparable
{
    protected $lastName;
    protected $firstName;
    protected $username;
    protected $email;
    protected $birthDate;

    public function __construct(array $data)
    {
        $this->lastName = $data['lastName'];
        $this->firstName = $data['firstName'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->birthDate = $data['birthDate'];
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function username()
    {
        return $this->username;
    }

    public function email()
    {
        return $this->email;
    }

    public function birthDate()
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

        assert(
            Test::areSameType($this, $object),
            sprintf('Comparison requires instance of %s', static::class)
        );

        $comp = strnatcmp($this->username(), $object->username());

        if ($comp > 0) {
            return 1;
        }
        if ($comp < 0) {
            return -1;
        }

        return 0;
    }
}
