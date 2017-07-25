<?php

namespace Novuso\Test\System\Resources;

use Novuso\System\Type\Enum;

final class InvalidStatus extends Enum
{
    public const CREATED = 0;
    public const IN_REVIEW = 1;
    public const APPROVED = true;
    public const DENIED = false;
    public const DELETED = 'deleted';
    public const PUBLISHED = true;
}
