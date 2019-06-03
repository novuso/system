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
     * @param string $state The serialized state
     *
     * @return Serializable
     *
     * @throws DomainException When the state is not valid
     */
    public function deserialize(string $state): Serializable;

    /**
     * Retrieves serialized state from an object
     *
     * @param Serializable $object A Serializable instance
     *
     * @return string
     */
    public function serialize(Serializable $object): string;
}
