<?php declare(strict_types=1);

namespace Novuso\System\Type;

/**
 * Interface Arrayable
 */
interface Arrayable
{
    /**
     * Retrieves an array representation
     *
     * @return array
     */
    public function toArray(): array;
}
