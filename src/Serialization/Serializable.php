<?php declare(strict_types=1);

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
     * @param array $data The serialized representation
     *
     * @return Serializable
     *
     * @throws DomainException When the data is not valid
     */
    public static function arrayDeserialize(array $data);

    /**
     * Retrieves a serialized representation
     *
     * @return array
     */
    public function arraySerialize(): array;
}
