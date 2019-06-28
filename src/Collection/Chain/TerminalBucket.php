<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Class TerminalBucket
 */
final class TerminalBucket implements Bucket
{
    /**
     * Next bucket
     *
     * @var Bucket|null
     */
    protected $next;

    /**
     * Previous bucket
     *
     * @var Bucket|null
     */
    protected $prev;

    /**
     * {@inheritdoc}
     */
    public function setNext(?Bucket $next): void
    {
        $this->next = $next;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): ?Bucket
    {
        return $this->next;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrev(?Bucket $prev): void
    {
        $this->prev = $prev;
    }

    /**
     * {@inheritdoc}
     */
    public function prev(): ?Bucket
    {
        return $this->prev;
    }
}
