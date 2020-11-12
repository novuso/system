<?php declare(strict_types=1);

namespace Novuso\System\Collection\Traits;

/**
 * Trait ItemTypeMethods
 */
trait ItemTypeMethods
{
    private ?string $itemType;

    /**
     * Retrieves the item type
     *
     * Returns null if the item type is dynamic.
     */
    public function itemType(): ?string
    {
        return $this->itemType;
    }

    /**
     * Sets the item type
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     */
    protected function setItemType(?string $itemType = null): void
    {
        $this->itemType = $itemType;
    }
}
