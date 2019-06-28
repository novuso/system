<?php declare(strict_types=1);

namespace Novuso\System\Collection\Mixin;

/**
 * Trait ItemTypeMethods
 */
trait ItemTypeMethods
{
    /**
     * Item type
     *
     * @var string|null
     */
    private $itemType;

    /**
     * Retrieves the item type
     *
     * Returns null if the item type is dynamic.
     *
     * @return string|null
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
     *
     * @param string|null $itemType The item type
     *
     * @return void
     */
    protected function setItemType(?string $itemType = null): void
    {
        if ($itemType !== null) {
            $itemType = trim($itemType);
        }

        $this->itemType = $itemType;
    }
}
