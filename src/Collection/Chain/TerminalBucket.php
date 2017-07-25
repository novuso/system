<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * TerminalBucket is a terminating bucket chain node
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class TerminalBucket implements BucketInterface
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
}
