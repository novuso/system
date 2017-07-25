<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Utility\ClassName;
use Novuso\System\Utility\Validate;

/**
 * JsonSerializer is a JSON encoding serializer
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class JsonSerializer implements SerializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function deserialize(string $state): SerializableInterface
    {
        $data = json_decode($state, $array = true);

        $keys = ['type', 'data'];
        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                $message = sprintf('Invalid serialization format: %s', $state);
                throw new DomainException($message);
            }
        }

        $class = ClassName::full($data['type']);

        assert(
            Validate::implementsInterface($class, SerializableInterface::class),
            sprintf('Unable to deserialize: %s; does not implement %s', $class, SerializableInterface::class)
        );

        /** @var SerializableInterface|string $class */
        return $class::deserialize($data['data']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(SerializableInterface $object): string
    {
        $data = [
            'type' => ClassName::canonical($object),
            'data' => $object->serialize()
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
