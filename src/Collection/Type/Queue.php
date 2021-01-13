<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Type;

use JsonSerializable;
use Novuso\System\Collection\Contract\ItemCollection;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Arrayable;

/**
 * Interface Queue
 */
interface Queue extends Arrayable, ItemCollection, JsonSerializable
{
    /**
     * Adds an item to the end
     */
    public function enqueue(mixed $item): void;

    /**
     * Removes and returns the front item
     *
     * @throws UnderflowException When the queue is empty
     */
    public function dequeue(): mixed;

    /**
     * Retrieves the front item without removal
     *
     * @throws UnderflowException When the queue is empty
     */
    public function front(): mixed;

    /**
     * Retrieves an array representation
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
