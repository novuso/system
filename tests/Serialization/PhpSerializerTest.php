<?php declare(strict_types=1);

namespace Novuso\System\Test\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Serialization\PhpSerializer;
use Novuso\System\Test\Resources\TestUser;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Serialization\PhpSerializer
 */
class PhpSerializerTest extends UnitTestCase
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
        $serializer = new PhpSerializer();
        $state = $serializer->serialize($this->user);
        $this->assertSame($this->getUserState(), $state);
    }

    public function test_that_deserialize_returns_expected_instance()
    {
        $serializer = new PhpSerializer();
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
        $serializer = new PhpSerializer();
        $serializer->deserialize(serialize([
            'firstName' => 'James',
            'lastName'  => 'Wood',
            'username'  => 'jwood',
            'email'     => 'jwood@example.com',
            'birthDate' => '1980-10-20'
        ]));
    }

    protected function getUserState()
    {
        return serialize([
            '@' => 'Novuso.System.Test.Resources.TestUser',
            '$' => [
                'lastName'  => 'Wood',
                'firstName' => 'James',
                'username'  => 'jwood',
                'email'     => 'jwood@example.com',
                'birthDate' => '1980-10-20'
            ]
        ]);
    }
}
