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
     */
    public function addFirst(mixed $item): void;

    /**
     * Adds an item to the end
     */
    public function addLast(mixed $item): void;

    /**
     * Removes and returns the first item
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeFirst(): mixed;

    /**
     * Removes and returns the last item
     *
     * @throws UnderflowException When the deque is empty
     */
    public function removeLast(): mixed;

    /**
     * Retrieves the first item without removal
     *
     * @throws UnderflowException When the deque is empty
     */
    public function first(): mixed;

    /**
     * Retrieves the last item without removal
     *
     * @throws UnderflowException When the deque is empty
     */
    public function last(): mixed;

    /**
     * Retrieves array representation
     */
    public function toArray(): array;

    /**
     * Retrieves a JSON representation
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string;

    /**
     * Retrieves a representation for JSON encoding
     */
    public function jsonSerialize(): array;

    /**
     * Retrieves a string representation
     */
    public function toString(): string;

    /**
     * Handles casting to a string
     */
    public function __toString(): string;
}
