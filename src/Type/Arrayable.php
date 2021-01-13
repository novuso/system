<?php

declare(strict_types=1);

namespace Novuso\System\Type;

/**
 * Interface Arrayable
 */
interface Arrayable
{
    /**
     * Retrieves array representation
     */
    public function toArray(): array;
}
