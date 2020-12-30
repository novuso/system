<?php

declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use Novuso\System\Type\Enum;

/**
 * Class TestStatus
 *
 * @method static ON
 * @method static OFF
 */
class TestStatus extends Enum
{
    public const ON = 'on';
    public const OFF = 'off';
}
