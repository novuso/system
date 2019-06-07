<?php declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface Deque
 */
interface Deque extends Arrayable, ItemCollection, JsonSerializable
{
    /**
     * Adds an item to the front
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function addFirst($item): void;

    /**
     * Adds an item to the end
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function addLast($item): void;

    /**
     * Removes and returns the first item
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeFirst();

    /**
     * Removes and returns the last item
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeLast();

    /**
     * Retrieves the first item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function first();

    /**
     * Retrieves the last item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the deque is empty
     */
    public function last();

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
