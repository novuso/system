<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Class ItemBucket
 */
final class ItemBucket implements Bucket
{
    protected ?Bucket $next = null;
    protected ?Bucket $prev = null;

    /**
     * Constructs ItemBucket
     */
    public function __construct(protected mixed $item) {}

    /**
     * @inheritDoc
     */
    public function setNext(?Bucket $next): void
    {
        $this->next = $next;
    }

    /**
     * @inheritDoc
     */
    public function next(): ?Bucket
    {
        return $this->next;
    }

    /**
     * @inheritDoc
     */
    public function setPrev(?Bucket $prev): void
    {
        $this->prev = $prev;
    }

    /**
     * @inheritDoc
     */
    public function prev(): ?Bucket
    {
        return $this->prev;
    }

    /**
     * Retrieves the item
     */
    public function item(): mixed
    {
        return $this->item;
    }
}
