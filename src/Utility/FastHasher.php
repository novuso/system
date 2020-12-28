<?php declare(strict_types=1);

namespace Novuso\System\Utility;

/**
 * Class FastHasher
 */
final class FastHasher
{
    /**
     * Creates a string hash for a value
     */
    public static function hash(mixed $value, string $algorithm = 'fnv1a32'): string
    {
        $type = gettype($value);

        switch ($type) {
            case 'object':
                if (Validate::isEquatable($value)) {
                    $string = sprintf('e_%s', $value->hashValue());
                } else {
                    $string = sprintf('o_%s', spl_object_hash($value));
                }
                break;
            case 'string':
                $string = sprintf('s_%s', $value);
                break;
            case 'integer':
                $string = sprintf('i_%d', $value);
                break;
            case 'double':
                $string = sprintf('f_%.14F', $value);
                break;
            case 'boolean':
                $string = sprintf('b_%d', (int) $value);
                break;
            case 'resource':
                $string = sprintf('r_%d', get_resource_id($value));
                break;
            case 'array':
                $string = sprintf('a_%s', serialize($value));
                break;
            default:
                $string = '0';
                break;
        }

        return hash($algorithm, $string);
    }
}
