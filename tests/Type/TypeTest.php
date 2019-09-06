<?php declare(strict_types=1);

namespace Novuso\System\Test\Type;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Type\Type;
use Novuso\System\Utility\ClassName;

/**
 * @covers \Novuso\System\Type\Type
 */
class TypeTest extends UnitTestCase
{
    public function test_that_create_returns_expected_instance()
    {
        $type = Type::create($this);
        $expected = str_replace('\\', '.', get_class($this));
        $this->assertSame($expected, $type->toString());
    }

    public function test_that_to_class_name_returns_full_class_name()
    {
        $type = Type::create($this);
        $expected = get_class($this);
        $this->assertSame($expected, $type->toClassName());
    }

    public function test_that_it_is_string_castable()
    {
        $type = Type::create($this);
        $expected = str_replace('\\', '.', get_class($this));
        $this->assertSame($expected, (string) $type);
    }

    public function test_that_it_is_json_encodable()
    {
        $type = Type::create($this);
        $data = ['type' => $type];
        $expected = sprintf('{"type":"%s"}', str_replace('\\', '.', get_class($this)));
        $this->assertSame($expected, json_encode($data));
    }

    public function test_that_it_is_serializable()
    {
        $state = serialize(Type::create($this));
        $type = unserialize($state);
        $this->assertSame(str_replace('\\', '.', get_class($this)), (string) $type);
    }

    public function test_that_serialize_returns_expected_state()
    {
        // TODO: update these tests when php7.4 is released
        $state = Type::create($this)->__serialize();
        $this->assertSame(ClassName::canonical($this), $state['name']);
    }

    public function test_that_unserialize_works_as_expected()
    {
        // TODO: update these tests when php7.4 is released
        $data = ['name' => ClassName::canonical($this)];
        $type = Type::create($this);
        $type->__unserialize($data);
        $this->assertSame(ClassName::canonical($this), $type->toString());
    }

    public function test_that_equals_returns_true_for_same_instance()
    {
        $type = Type::create($this);
        $this->assertTrue($type->equals($type));
    }

    public function test_that_equals_returns_true_for_same_value()
    {
        $type1 = Type::create($this);
        $type2 = Type::create($this);
        $this->assertTrue($type1->equals($type2));
    }

    public function test_that_equals_returns_false_for_invalid_value()
    {
        $type = Type::create($this);
        $this->assertFalse($type->equals(get_class($this)));
    }

    public function test_that_equals_returns_false_for_unequal_value()
    {
        $type1 = Type::create($this);
        $type2 = Type::create(new \ArrayObject());
        $this->assertFalse($type1->equals($type2));
    }

    public function test_that_hash_value_returns_expected_string()
    {
        $type = Type::create($this);
        $expected = str_replace('\\', '.', get_class($this));
        $this->assertSame($expected, $type->hashValue());
    }
}
