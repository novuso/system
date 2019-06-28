<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface Stack
 */
interface Stack extends Arrayable, ItemCollection, JsonSerializable
{
    /**
     * Adds an item to the top
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function push($item): void;

    /**
     * Removes and returns the top item
     *
     * @return mixed
     *
     * @throws UnderflowException When the stack is empty
     */
    public function pop();

    /**
     * Retrieves the top item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the stack is empty
     */
    public function top();

    /**
     * Retrieves an array representation
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Retrieves a JSON representation
     *
     * @param int $options Bitmask options for JSON encode
     *
     * @return string
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string;

    /**
     * Retrieves a representation for JSON encoding
     *
     * @return array
     */
    public function jsonSerialize(): array;

    /**
     * Retrieves a string representation
     *
     * @return string
     */
    public function toString(): string;

    /**
     * Handles casting to a string
     *
     * @return string
     */
    public function __toString(): string;
}
