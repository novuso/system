<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;

/**
 * Interface Serializer
 */
interface Serializer
{
    /**
     * Creates instance from a serialized state
     *
     * @throws DomainException When the state is not valid
     */
    public function deserialize(string $state): Serializable;

    /**
     * Retrieves serialized state from an object
     */
    public function serialize(Serializable $object): string;
}
