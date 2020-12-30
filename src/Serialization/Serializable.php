<?php

declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;

/**
 * Interface Serializable
 */
interface Serializable
{
    /**
     * Creates instance from a serialized representation
     *
     * @throws DomainException When the data is not valid
     */
    public static function arrayDeserialize(array $data): static;

    /**
     * Retrieves a serialized representation
     */
    public function arraySerialize(): array;
}
