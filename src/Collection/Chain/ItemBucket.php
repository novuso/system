<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Class ItemBucket
 */
final class ItemBucket implements Bucket
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
     * Bucket item
     *
     * @var mixed
     */
    protected $item;

    /**
     * Constructs ItemBucket
     *
     * @param mixed $item The item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

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

    /**
     * Retrieves the item
     *
     * @return mixed
     */
    public function item()
    {
        return $this->item;
    }
}
