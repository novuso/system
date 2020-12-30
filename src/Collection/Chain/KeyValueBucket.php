<?php

declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Class KeyValueBucket
 */
final class KeyValueBucket implements Bucket
{
    protected ?Bucket $next = null;
    protected ?Bucket $prev = null;

    /**
     * Constructs KeyValueBucket
     *
     * @codeCoverageIgnore coverage bug
     */
    public function __construct(protected mixed $key, protected mixed $value)
    {
    }

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
     * Retrieves the key
     */
    public function key(): mixed
    {
        return $this->key;
    }

    /**
     * Retrieves the value
     */
    public function value(): mixed
    {
        return $this->value;
    }
}
