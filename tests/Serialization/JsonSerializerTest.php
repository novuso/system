<?php declare(strict_types=1);

namespace Novuso\System\Test\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Serialization\JsonSerializer;
use Novuso\System\Test\Resources\TestUser;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Serialization\JsonSerializer
 */
class JsonSerializerTest extends UnitTestCase
{
    /** @var TestUser */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new TestUser([
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
        /** @var TestUser $user */
        $user = $serializer->deserialize($this->getUserState());
        $this->assertTrue(
            'James' === $user->firstName()
            && 'Wood' === $user->lastName()
            && 'jwood' === $user->username()
            && 'jwood@example.com' === $user->email()
            && '1980-10-20' === $user->birthDate()
        );
    }

    public function test_that_deserialize_throws_exception_for_invalid_state()
    {
        $this->expectException(DomainException::class);
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
            '@' => 'Novuso.System.Test.Resources.TestUser',
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
