<?php declare(strict_types=1);

namespace Novuso\System\Type;

/**
 * Arrayable is the interface for types that provide array representation
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface Arrayable
{
    /**
     * Retrieves an array representation
     *
     * @return array
     */
    public function toArray(): array;
}
