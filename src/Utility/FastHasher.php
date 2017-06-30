<?php declare(strict_types=1);

namespace Novuso\System\Utility;

/**
 * FastHasher is a non-cryptographic hashing utility
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class FastHasher
{
    /**
     * Creates a string hash for a value
     *
     * @param mixed  $value The value
     * @param string $algo  The hash algorithm
     *
     * @return string
     */
    public static function hash($value, string $algo = 'fnv1a32'): string
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
                $string = sprintf('r_%d', (int) $value);
                break;
            case 'array':
                $string = sprintf('a_%s', serialize($value));
                break;
            default:
                $string = '0';
                break;
        }

        return hash($algo, $string);
    }
}
