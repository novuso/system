<?php declare(strict_types=1);

namespace Novuso\System\Test\Type;

use Novuso\System\Test\TestCase\UnitTestCase;
use Novuso\System\Type\Type;

/**
 * @covers \Novuso\System\Type\Type
 */
class TypeTest extends UnitTestCase
{
    public function test_that_to_class_name_returns_expected_value()
    {
        $className = 'Novuso\\System\\Type\\Type';
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertSame($className, $type->toClassName());
    }

    public function test_that_to_string_returns_expected_value()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertSame($canonical, $type->toString());
    }

    public function test_that_string_cast_returns_expected_value()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertSame($canonical, (string) $type);
    }

    public function test_that_it_is_json_encodable()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        $data = [
            'type' => $type
        ];

        static::assertSame('{"type":"Novuso.System.Type.Type"}', json_encode($data));
    }

    public function test_that_it_is_serializable()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertTrue(unserialize(serialize($type))->equals($type));
    }

    public function test_that_equals_returns_true_when_same_instance()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertTrue($type->equals($type));
    }

    public function test_that_equals_returns_false_when_different_types()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertFalse($type->equals($canonical));
    }

    public function test_that_equals_returns_true_when_equal()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type1 = Type::create($canonical);
        $type2 = Type::create($canonical);

        static::assertTrue($type1->equals($type2));
    }

    public function test_that_hash_value_returns_expected_value()
    {
        $canonical = 'Novuso.System.Type.Type';

        $type = Type::create($canonical);

        static::assertSame($canonical, $type->hashValue());
    }
}
