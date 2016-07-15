<?php declare(strict_types=1);

namespace Novuso\System\Collection\Traits;

use Novuso\System\Utility\VarPrinter;

/**
 * ItemTypeMethods provides type methods for item collections
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
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
    public function itemType()
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
    protected function setItemType(string $itemType = null)
    {
        if ($itemType !== null) {
            $itemType = trim($itemType);
        }

        $this->itemType = $itemType;
    }

    /**
     * Retrieves the item type error message
     *
     * @param string $method The calling method
     * @param mixed  $item   The item
     *
     * @return string
     */
    protected function itemTypeError(string $method, $item): string
    {
        $itemType = is_object($item) ? get_class($item) : gettype($item);

        return sprintf(
            '%s::%s expects item type (%s); received (%s) %s',
            static::class,
            $method,
            $this->itemType(),
            $itemType,
            VarPrinter::toString($item)
        );
    }
}
