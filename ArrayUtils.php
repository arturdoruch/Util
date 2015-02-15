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
        return array_filter($haystack, function($value) use ($needle) {
            if (strtolower($needle) == strtolower($value)) {
                return true;
            }
        });
    }
}
 