<?php

declare(strict_types=1);

namespace Novuso\System\Utility;

/**
 * Class Environment
 */
final class Environment
{
    /**
     * Retrieves the value of an environment variable
     */
    public static function get(
        string $key,
        string|bool|null $default = null
    ): string|bool|null {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (
            strlen($value) > 1
            && substr($value, 0, 1) === '"'
            && substr($value, -1, 1) === '"'
        ) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}
