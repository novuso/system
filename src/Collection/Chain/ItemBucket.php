<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * ItemBucket is a bucket that contains an item
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ItemBucket implements BucketInterface
{
    /**
     * Next bucket
     *
     * @var BucketInterface|null
     */
    protected $next;

    /**
     * Previous bucket
     *
     * @var BucketInterface|null
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
    public function setNext(?BucketInterface $next): void
    {
        $this->next = $next;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): ?BucketInterface
    {
        return $this->next;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrev(?BucketInterface $prev): void
    {
        $this->prev = $prev;
    }

    /**
     * {@inheritdoc}
     */
    public function prev(): ?BucketInterface
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
