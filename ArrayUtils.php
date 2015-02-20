<?php
/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */

namespace ArturDoruch\Util;

class ArrayUtils
{
    /**
     * Checks with case insensitive if a value exists in an array.
     *
     * @param mixed $needle
     * @param array $haystack
     *
     * @return bool
     */
    public static function inArrayI($needle, array $haystack)
    {
        foreach ($haystack as $value) {
            if (!is_array($value) && strtolower($needle) == strtolower($value)) {
                return true;
            }
        }

        return false;
    }
}
 