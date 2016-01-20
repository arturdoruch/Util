<?php
/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */

namespace ArturDoruch\Util;

class FileUtils
{
    /**
     * @param string $fileName
     *
     * @throws \RuntimeException
     *
     * @return array File content as array.
     */
    public static function getFileContent($fileName)
    {
        if (!file_exists($fileName)) {
            throw new \RuntimeException('The file "' . $fileName . '" is not exist.');
        }

        return file($fileName, FILE_IGNORE_NEW_LINES);
    }

    /**
     * Converts size integer value into human readable format.
     *
     * @param int $size The file size in bytes.
     * @param int $precision
     *
     * @return string
     */
    public static function humanizeSize($size, $precision = 2)
    {
        if ($size < 1024) {
            return $size . ' B';
        }

        if ($size < 1048576) {
            return round($size / 1024, $precision) . ' KB';
        }

        if ($size >= 1048576 && $size < 1073741824) {
            return round($size / 1048576, $precision) . ' MB';
        }

        return round($size / 1073741824, $precision) . ' GB';
    }

}
