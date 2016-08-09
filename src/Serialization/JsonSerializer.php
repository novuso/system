<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Utility\ClassName;

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

        /** @var Serializable $class */
        $class = ClassName::full($data['@']);

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
