<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;

/**
 * Serializable is the interface for serializable types
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface Serializable
{
    /**
     * Creates instance from a serialized representation
     *
     * @param array $data The serialized representation
     *
     * @return Serializable
     *
     * @throws DomainException When the data is not valid
     */
    public static function deserialize(array $data);

    /**
     * Retrieves a serialized representation
     *
     * @return array
     */
    public function serialize(): array;
}
