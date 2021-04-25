<?php

namespace ArturDoruch\Util;

/**
 * @deprecated Use the "arturdoruch/filesystem" component instead.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class FileUtils
{
    /**
     * Reads file into a string or an array (if $asArray is set to true).
     *
     * @param string $filename The path to file.
     * @param bool   $asArray  If true returns file content as an array otherwise as a string.
     *
     * @return string|array The file content.
     */
    public static function getFileContent($filename, $asArray = false)
    {
        $content = $asArray === true ? @file($filename, FILE_IGNORE_NEW_LINES) : @file_get_contents($filename);

        if (false === $content) {
            if (is_dir($filename)) {
                $error = 'The filename "'.$filename.'" is not a file.';
            } elseif (strlen($filename) > 255 && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // On Windows PHP can't read file with path length greater then 255 characters.
                $error = 'The file "'.$filename.'" cannot be read. The path length is too long.';
            } elseif (!file_exists($filename)) {
                $error = 'The file "'.$filename.'" does not exist.';
            } else {
                $error = self::getLastError();
            }

            throw new \RuntimeException($error);
        }

        return $content;
    }

    /**
     * @param string $filename
     * @param mixed $data
     * @param null $flags
     *
     * @return int
     * @throws \RuntimeException when file put contents failure
     */
    public static function putContents($filename, $data, $flags = null)
    {
        if (false === $result = @file_put_contents($filename, $data, $flags)) {
            throw new \RuntimeException(sprintf('Failed put contents into file "%s": %s', $filename, self::getLastError()));
        }

        return $result;
    }

    /**
     * @param string $filename
     * @param string $data
     *
     * @return int
     */
    public static function writeToNewLine($filename, $data)
    {
        return self::putContents($filename, $data.PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $filename
     */
    public static function remove($filename)
    {
        if (@unlink($filename) === false) {
            throw new \RuntimeException(sprintf('Failed to remove "%s". %s', $filename, self::getLastError()));
        }
    }

    /**
     * @param string $origin The path to original file.
     * @param string $target The path to original file.
     */
    public static function rename($origin, $target)
    {
        if (@rename($origin, $target) === false) {
            throw new \RuntimeException(sprintf('Failed to rename "%s". %s', $origin, self::getLastError()));
        }
    }

    /**
     * Creates a directory recursively if does not exist.
     *
     * @param string $directory The directory path.
     * @param int $mode
     *
     * @throws \RuntimeException
     */
    public static function createDirectory($directory, $mode = 0777)
    {
        if (is_dir($directory)) {
            return;
        }

        if (@mkdir($directory, $mode, true) === false) {
            throw new \RuntimeException(sprintf('Failed to create directory "%s". %s', $directory, self::getLastError()));
        }
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
            return $size.' B';
        }

        if ($size < 1048576) {
            return round($size / 1024, $precision).' KB';
        }

        if ($size >= 1048576 && $size < 1073741824) {
            return round($size / 1048576, $precision).' MB';
        }

        return round($size / 1073741824, $precision).' GB';
    }

    /**
     * @return string
     */
    private static function getLastError()
    {
        $error = error_get_last();

        return substr($error['message'], strpos($error['message'], '):') + 3);
    }
}
