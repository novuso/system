<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;

/**
 * SerializerInterface is the interface for a serializer
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface SerializerInterface
{
    /**
     * Creates instance from a serialized state
     *
     * @param string $state The serialized state
     *
     * @return SerializableInterface
     *
     * @throws DomainException When the state is not valid
     */
    public function deserialize(string $state): SerializableInterface;

    /**
     * Retrieves serialized state from an object
     *
     * @param SerializableInterface $object A SerializableInterface instance
     *
     * @return string
     */
    public function serialize(SerializableInterface $object): string;
}
