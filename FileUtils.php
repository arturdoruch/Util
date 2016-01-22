<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class FileUtils
{
    /**
     * Gets file content as array.
     *
     * @param string $filename The path to file.
     *
     * @throws \RuntimeException
     * @return array The file content as array.
     */
    public static function getFileContent($filename)
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException('The file "' . $filename . '" is not exist.');
        }

        return file($filename, FILE_IGNORE_NEW_LINES);
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
