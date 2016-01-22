<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class ArrayUtils
{
    /**
     * Checks if a value exists in an array with case insensitive.
     *
     * @param array  $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function inArrayI(array $haystack, $needle)
    {
        return !!array_filter($haystack, function ($value) use ($needle) {
               return !is_array($value) && strtolower($needle) == strtolower($value);
            });
    }

    /**
     * Converts array into object.
     *
     * @param array $array
     * @param bool  $recursive
     * @param bool  $lowerCaseKey If array keys should be converted to lowercase object property name.
     * @return \stdClass
     */
    public static function toObject(array $array, $recursive = true, $lowerCaseKey = true)
    {
        $object = new \stdClass();

        foreach ($array as $name => $value) {
            if (is_array($value) && $recursive === true) {
                $value = self::toObject($value, $recursive, $lowerCaseKey);
            }

            if ($lowerCaseKey === true) {
                $name = strtolower($name);
            }
            $object->$name = $value;
        }

        return $object;
    }

    /**
     * Insert a new array item into an existing array.
     *
     * @param array $array    The existing array
     * @param array $newArray A new array
     * @param int   $position
     */
    public static function insert(array &$array, array $newArray, $position)
    {
        $spliceArray = array_splice($array, 0, $position);
        $array = array_merge($spliceArray, $newArray, $array);
    }

    /**
     * Recursively merges values from two arrays. Matching keys values
     * in the second array and overwrite those in the first array.
     * E.g. mergeDistinctly(
     *      ['key' => 'org value', 'foo' => 'bar'],
     *      ['key' => 'new value']
     * ) => ['key' => 'new value', 'foo' => 'bar']
     *
     * Code taken from
     * @link http://www.php.net/manual/en/function.array-merge-recursive.php#92195
     *
     * @param array $baseArray  The array with default values
     * @param array $array      The array with new values
     *
     * @return array
     */
    public static function mergeDistinctly(array $baseArray, array $array)
    {
        $output = $baseArray;

        foreach ($array as $key => $value) {
            if (is_array($value) && isset($output[$key]) && is_array($output[$key])) {
                $output[$key] = self::mergeDistinctly($output[$key], $value);
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    /**
     * Flattens multidimensional array.
     *
     * @param array $array
     * @param bool  $preserveKeys If true leaves current array keys name.
     *
     * @return array The flattened multidimensional array.
     */
    public static function flatten(array $array, $preserveKeys = false)
    {
        $flatten = array();
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));

        foreach($iterator as $key => $value) {
            if ($preserveKeys === true) {
                $flatten[$key] = $value;
            } else {
                $flatten[] = $value;
            }
        }

        return $flatten;
    }

    /**
     * Builds array tree structure. Code taken from
     * @link http://stackoverflow.com/questions/8020947
     *
     * @param array         $items
     * @param string|number $id
     * @param string|number $parentId
     * @param string|number $childKey
     *
     * @return array|null
     */
    public static function buildTree(array $items, $id, $parentId, $childKey)
    {
        if (empty($items)) {
            return null;
        }

        $hash = array();
        foreach ($items as $item) {
            if (is_object($item)) {
                $item = (array) $item;
            }
            if (isset($item[$id])) {
                $hash[$item[$id]] = $item;
            }
        }

        $itemsTree = array();

        foreach ($hash as $id => &$node) {
            if ($parent = $node[$parentId]) {
                $hash[$parentId][$childKey][] =& $node;
            } else {
                $itemsTree[] =& $node;
            }
        }
        unset($node, $hash);

        return $itemsTree;
    }

    /**
     * Founds items branch in array tree.
     *
     * @param string     $searchField
     * @param string|int $searchValue
     * @param array      $items
     *
     * @return array Items branch
     */
    public static function findBranch($searchField, $searchValue, array $items)
    {
        $branch = array();

        $iterationArray = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($items));

        foreach ($iterationArray as $sub) {
            $subArray = $iterationArray->getSubIterator();
            if ($subArray[$searchField] === $searchValue) {
                $branch[] = iterator_to_array($subArray);
            }
        }

        return $branch;
    }

    /**
     * Parse json object into array
     *
     * @param string       $json        JSON object
     * @param array|string $defaultKeys Default keys (if is array with their values) that should be in returned array.
     *
     * @return array
     */
    public static function jsonDecode($json, $defaultKeys = null)
    {
        $data = array();

        if (!empty($defaultKeys)) {
            if (is_array($defaultKeys)) {
                $data = $defaultKeys;
            } else {
                $data[$defaultKeys] = null;
            }
        }

        if (!empty($json)) {
            $dataDecode = json_decode($json, true);

            if (is_array($dataDecode)) {
                $data = $dataDecode + $data;
            }
        }

        return $data;
    }

}
 