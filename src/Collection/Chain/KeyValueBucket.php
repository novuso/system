<?php declare(strict_types=1);

namespace Novuso\System\Collection\Chain;

/**
 * Class KeyValueBucket
 */
final class KeyValueBucket implements Bucket
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
     * Bucket key
     *
     * @var mixed
     */
    protected $key;

    /**
     * Bucket value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructs KeyValueBucket
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
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
     * Retrieves the key
     *
     * @return mixed
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Retrieves the value
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
