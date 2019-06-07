<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Interface Bucket
 */
interface Bucket
{
    /**
     * Sets the next bucket
     *
     * @param Bucket|null $next The next bucket or null to unset
     *
     * @return void
     */
    public function setNext(?Bucket $next): void;

    /**
     * Retrieves the next bucket
     *
     * @return Bucket|null
     */
    public function next(): ?Bucket;

    /**
     * Sets the previous bucket
     *
     * @param Bucket|null $prev The previous bucket or null to unset
     *
     * @return void
     */
    public function setPrev(?Bucket $prev): void;

    /**
     * Retrieves the previous bucket
     *
     * @return Bucket|null
     */
    public function prev(): ?Bucket;
}
