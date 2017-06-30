<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * TerminalBucket is a terminating bucket chain node
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class TerminalBucket implements Bucket
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
