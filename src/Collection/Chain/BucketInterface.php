<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * BucketInterface is the interface for a bucket chain node
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface BucketInterface
{
    /**
     * Sets the next bucket
     *
     * @param BucketInterface|null $next The next bucket or null to unset
     *
     * @return void
     */
    public function setNext(?BucketInterface $next): void;

    /**
     * Retrieves the next bucket
     *
     * @return BucketInterface|null
     */
    public function next(): ?BucketInterface;

    /**
     * Sets the previous bucket
     *
     * @param BucketInterface|null $prev The previous bucket or null to unset
     *
     * @return void
     */
    public function setPrev(?BucketInterface $prev): void;

    /**
     * Retrieves the previous bucket
     *
     * @return BucketInterface|null
     */
    public function prev(): ?BucketInterface;
}
