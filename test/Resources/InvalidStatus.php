<?php

namespace Novuso\Test\System\Resources;

use Novuso\System\Type\Enum;

final class InvalidStatus extends Enum
{
    const CREATED = 0;
    const IN_REVIEW = 1;
    const APPROVED = true;
    const DENIED = false;
    const DELETED = 'deleted';
    const PUBLISHED = true;
}
