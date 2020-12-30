<?php

declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use Novuso\System\Type\Enum;

/**
 * Class TestInvalidStatus
 *
 * @method static CREATED
 * @method static IN_REVIEW
 * @method static APPROVED
 * @method static DENIED
 * @method static DELETED
 * @method static PUBLISHED
 */
class TestInvalidStatus extends Enum
{
    public const CREATED = 0;
    public const IN_REVIEW = 1;
    public const APPROVED = true;
    public const DENIED = false;
    public const DELETED = 'deleted';
    public const PUBLISHED = true;
}
