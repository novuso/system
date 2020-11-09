<?php declare(strict_types=1);

namespace Novuso\System\Serialization;

use Novuso\System\Exception\DomainException;
use Novuso\System\Utility\ClassName;

/**
 * Class JsonSerializer
 */
final class JsonSerializer implements Serializer
{
    /**
     * @inheritDoc
     */
    public function deserialize(string $state): Serializable
    {
        $data = json_decode($state, $array = true);

        $keys = ['@', '$'];
        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                $message = sprintf('Invalid serialization format: %s', $state);
                throw new DomainException($message);
            }
        }

        $class = ClassName::full($data['@']);

        /** @var Serializable|string $class */
        return $class::arrayDeserialize($data['$']);
    }

    /**
     * @inheritDoc
     */
    public function serialize(Serializable $object): string
    {
        $data = [
            '@' => ClassName::canonical($object),
            '$' => $object->arraySerialize()
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
