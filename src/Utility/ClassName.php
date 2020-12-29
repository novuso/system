<?php declare(strict_types=1);

namespace Novuso\System\Utility;

/**
 * Class ClassName
 */
final class ClassName
{
    /**
     * Retrieves the fully qualified class name of an object
     */
    public static function full(object|string $object): string
    {
        if (is_string($object)) {
            return str_replace('.', '\\', $object);
        }

        return trim($object::class, '\\');
    }

    /**
     * Retrieves the canonical class name of an object
     */
    public static function canonical(object|string $object): string
    {
        return str_replace('\\', '.', static::full($object));
    }

    /**
     * Retrieves the lowercase underscored class name of an object
     */
    public static function underscore(object|string $object): string
    {
        return strtolower(preg_replace(
            '/(?<=\\w)([A-Z])/',
            '_$1',
            static::canonical($object)
        ));
    }

    /**
     * Retrieves the short class name of an object
     */
    public static function short(object|string $object): string
    {
        $parts = explode('\\', static::full($object));

        return end($parts);
    }
}
