<?php declare(strict_types=1);

namespace Novuso\System\Utility;

use Closure;
use DateTimeInterface;
use Stringable;
use Throwable;

/**
 * Class VarPrinter
 */
final class VarPrinter
{
    /**
     * Reads a string representation from a value
     */
    public static function toString(mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if ($value === true) {
            return 'TRUE';
        }

        if ($value === false) {
            return 'FALSE';
        }

        if (is_resource($value)) {
            return sprintf(
                'Resource(%d:%s)',
                get_resource_id($value),
                get_resource_type($value)
            );
        }

        if (is_object($value)) {
            return static::readObject($value);
        }

        if (is_array($value)) {
            return static::readArray($value);
        }

        return (string) $value;
    }

    /**
     * Reads a string representation from an object
     */
    protected static function readObject(object $object): string
    {
        if ($object instanceof Closure) {
            return 'Function';
        }

        if ($object instanceof DateTimeInterface) {
            return sprintf('%s(%s)', ClassName::short($object), $object->format('Y-m-d\TH:i:sP'));
        }

        if ($object instanceof Throwable) {
            return sprintf('%s(%s)', ClassName::short($object), json_encode([
                'message' => $object->getMessage(),
                'code'    => $object->getCode(),
                'file'    => $object->getFile(),
                'line'    => $object->getLine()
            ], JSON_UNESCAPED_SLASHES));
        }

        if (method_exists($object, 'toString')) {
            return (string) $object->toString();
        }

        if ($object instanceof Stringable) {
            return (string) $object;
        }

        return sprintf('Object(%s)', ClassName::full($object));
    }

    /**
     * Reads a string representation from an array
     */
    protected static function readArray(array $array): string
    {
        $data = [];

        foreach ($array as $key => $value) {
            $data[] = sprintf('%s => %s', $key, static::toString($value));
        }

        return sprintf('Array(%s)', implode(', ', $data));
    }
}
