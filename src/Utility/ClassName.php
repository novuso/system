<?php declare(strict_types=1);

namespace Novuso\System\Utility;

use Novuso\System\Exception\TypeException;

/**
 * Class ClassName
 */
final class ClassName
{
    /**
     * Retrieves the fully qualified class name of an object
     *
     * @param object|string $object An object, fully qualified class name, or
     *                              canonical class name
     *
     * @return string
     *
     * @throws TypeException When $object is not a string or object
     */
    public static function full($object): string
    {
        if (is_string($object)) {
            return str_replace('.', '\\', $object);
        }

        if (is_object($object)) {
            return trim(get_class($object), '\\');
        }

        $message = sprintf(
            '%s expects $object to be an object or string; received (%s) %s',
            __METHOD__,
            gettype($object),
            VarPrinter::toString($object)
        );
        throw new TypeException($message);
    }

    /**
     * Retrieves the canonical class name of an object
     *
     * @param object|string $object An object, fully qualified class name, or
     *                              canonical class name
     *
     * @return string
     *
     * @throws TypeException When $object is not a string or object
     */
    public static function canonical($object): string
    {
        return str_replace('\\', '.', static::full($object));
    }

    /**
     * Retrieves the lowercase underscored class name of an object
     *
     * @param object|string $object An object, fully qualified class name, or
     *                              canonical class name
     *
     * @return string
     *
     * @throws TypeException When $object is not a string or object
     */
    public static function underscore($object): string
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_$1', static::canonical($object)));
    }

    /**
     * Retrieves the short class name of an object
     *
     * @param object|string $object An object, fully qualified class name, or
     *                              canonical class name
     *
     * @return string
     *
     * @throws TypeException When $object is not a string or object
     */
    public static function short($object): string
    {
        $parts = explode('\\', static::full($object));

        return end($parts);
    }
}
