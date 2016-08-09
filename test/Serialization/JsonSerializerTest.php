<?php

namespace Novuso\Test\System\Serialization;

use Novuso\System\Serialization\JsonSerializer;
use Novuso\Test\System\Resources\User;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Serialization\JsonSerializer
 */
class JsonSerializerTest extends UnitTestCase
{
    /**
     * User
     *
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        $this->user = new User([
            'firstName' => 'James',
            'lastName'  => 'Wood',
            'username'  => 'jwood',
            'email'     => 'jwood@example.com',
            'birthDate' => '1980-10-20'
        ]);
    }

    public function test_that_serialize_returns_expected_state()
    {
        $serializer = new JsonSerializer();
        $state = $serializer->serialize($this->user);
        $this->assertSame($this->getUserState(), $state);
    }

    public function test_that_deserialize_returns_expected_instance()
    {
        $serializer = new JsonSerializer();
        /** @var User $user */
        $user = $serializer->deserialize($this->getUserState());
        $this->assertTrue(
            'James' === $user->firstName()
            && 'Wood' === $user->lastName()
            && 'jwood' === $user->username()
            && 'jwood@example.com' === $user->email()
            && '1980-10-20' === $user->birthDate()
        );
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_deserialize_throws_exception_for_invalid_state()
    {
        $serializer = new JsonSerializer();
        $serializer->deserialize(json_encode([
            'firstName' => 'James',
            'lastName'  => 'Wood',
            'username'  => 'jwood',
            'email'     => 'jwood@example.com',
            'birthDate' => '1980-10-20'
        ]));
    }

    protected function getUserState()
    {
        return json_encode([
            '@' => 'Novuso.Test.System.Resources.User',
            '$' => [
                'lastName'  => 'Wood',
                'firstName' => 'James',
                'username'  => 'jwood',
                'email'     => 'jwood@example.com',
                'birthDate' => '1980-10-20'
            ]
        ], JSON_UNESCAPED_SLASHES);
    }
}
