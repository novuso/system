<?php

namespace Novuso\Test\System\Type;

use Novuso\System\Type\Type;
use Novuso\Test\System\TestCase\UnitTestCase;

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
