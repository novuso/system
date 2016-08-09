<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;

/**
 * Serializer is the interface for a serializer
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
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
