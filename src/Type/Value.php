<?php

namespace Novuso\System\Type;

use JsonSerializable;
use Serializable;

/**
 * Value is the interface for a value object
 *
 * Implementations must adhere to value characteristics:
 *
 * * It is maintained as immutable
 * * It measures, quantifies, or describes a thing
 * * It models a conceptual whole by composing related attributes as a unit
 * * It is completely replaceable when the measurement or description changes
 * * It can be compared with others using value equality
 * * It supplies its collaborators with side-effect-free behavior
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface Value extends Equatable, JsonSerializable, Serializable
{
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

    /**
     * Retrieves a value for JSON encoding
     *
     * @return mixed
     */
    public function jsonSerialize();

    /**
     * Retrieves a serialized representation
     *
     * @return string
     */
    public function serialize(): string;

    /**
     * Handles construction from a serialized representation
     *
     * @param string $serialized The serialized representation
     *
     * @return void
     */
    public function unserialize($serialized): void;
}
