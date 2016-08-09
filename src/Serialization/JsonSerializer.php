<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Test;

/**
 * JsonSerializer is a JSON encoding serializer
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class JsonSerializer implements Serializer
{
    /**
     * {@inheritdoc}
     */
    public function deserialize(string $state): Serializable
    {
        $data = json_decode($state, true);

        $keys = ['@', '$'];
        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                $message = sprintf('Invalid serialization format: %s', $state);
                throw new DomainException($message);
            }
        }

        $class = ClassName::full($data['@']);

        assert(
            Test::implementsInterface($class, Serializable::class),
            sprintf('Unable to deserialize: %s', $class)
        );

        return $class::deserialize($data['$']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(Serializable $object): string
    {
        $data = [
            '@' => ClassName::canonical($object),
            '$' => $object->serialize()
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
