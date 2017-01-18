<?php declare(strict_types=1);

namespace Novuso\System\Collection\Sort;

/**
 * Merge implements the merge sort algorithm
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class Merge
{
    /**
     * Insertion sort cutoff
     *
     * @var int
     */
    const SORT_CUTOFF = 8;

    /**
     * Sorts an array with a stable sort
     *
     * @param array    &$arr The array
     * @param callable $comp The comparison function
     *
     * @return void
     */
    public static function sort(array &$arr, callable $comp)
    {
        $aux = $arr;
        static::partition($aux, $arr, 0, count($arr) - 1, $comp);
    }

    /**
     * Partitions and sorts array
     *
     * @param array    &$src The source array for this level
     * @param array    &$dst The destination array for this level
     * @param int      $lo   The lower bound
     * @param int      $hi   The upper bound
     * @param callable $comp The comparison function
     *
     * @return void
     */
    protected static function partition(array &$src, array &$dst, int $lo, int $hi, callable $comp)
    {
        if ($hi <= $lo + static::SORT_CUTOFF) {
            static::insertionSort($dst, $lo, $hi, $comp);

            return;
        }

        $mid = (int) ($lo + ($hi - $lo) / 2);
        static::partition($dst, $src, $lo, $mid, $comp);
        static::partition($dst, $src, $mid + 1, $hi, $comp);

        if (!static::lt($src[$mid + 1], $src[$mid], $comp)) {
            for ($i = $lo; $i <= $hi; $i++) {
                $dst[$i] = $src[$i];
            }

            return;
        }

        static::merge($src, $dst, $lo, $mid, $hi, $comp);
    }

    /**
     * Merges compared arrays
     *
     * @param array    &$src The source array
     * @param array    &$dst The destination array
     * @param int      $lo   The lower bound
     * @param int      $mid  The middle
     * @param int      $hi   The upper bound
     * @param callable $comp The comparison function
     *
     * @return void
     */
    protected static function merge(array &$src, array &$dst, int $lo, int $mid, int $hi, callable $comp)
    {
        $i = $lo;
        $j = $mid + 1;
        for ($k = $lo; $k <= $hi; $k++) {
            if ($i > $mid) {
                $dst[$k] = $src[$j++];
            } elseif ($j > $hi) {
                $dst[$k] = $src[$i++];
            } elseif (static::lt($src[$j], $src[$i], $comp)) {
                $dst[$k] = $src[$j++];
            } else {
                $dst[$k] = $src[$i++];
            }
        }
    }

    /**
     * Sorts small compared sub-arrays using insertion sort
     *
     * @param array    &$arr The array
     * @param int      $lo   The lower bound
     * @param int      $hi   The upper bound
     * @param callable $comp The comparison function
     *
     * @return void
     */
    protected static function insertionSort(array &$arr, int $lo, int $hi, callable $comp)
    {
        for ($i = $lo; $i <= $hi; $i++) {
            for ($j = $i; $j > $lo && static::lt($arr[$j], $arr[$j - 1], $comp); $j--) {
                static::exch($arr, $j, $j - 1);
            }
        }
    }

    /**
     * Exchanges two items in an array
     *
     * @param array &$arr The array
     * @param int   $i    The index of the first item
     * @param int   $j    The index of the second item
     *
     * @return void
     */
    protected static function exch(array &$arr, int $i, int $j)
    {
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
    }

    /**
     * Checks if a is less than b
     *
     * @param mixed    $a    The first item
     * @param mixed    $b    The second item
     * @param callable $comp The comparison function
     *
     * @return bool
     */
    protected static function lt($a, $b, callable $comp): bool
    {
        return $comp($a, $b) < 0;
    }
}
