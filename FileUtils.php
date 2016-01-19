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

        return file($fileName);
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


    public static function rename($originPath, $targetPath)
    {
        if (file_exists($originPath)) {
            return @rename($originPath, $targetPath);
        }

        return null;
    }


    public static function removeDir($dir)
    {
        if (file_exists($dir)) {
            return @rmdir($dir);
        }

        return null;
    }

    public static function read($filename)
    {
    	if ($handle = fopen($filename, 'r')) {
    		$text = @fread($handle, filesize($filename));
    		fclose($handle);
    		
    		return $text;
    	}

        return false;
    }

    public static function write($filename, $text, $mode = 'w')
    {
        if ($handle = fopen($filename, $mode)) {
    		fwrite($handle, $text);
    		fclose($handle);
            
    		return true;
    	}

    	return false;
    }   


    public static function writeToNewLine($filename, $text)
    {
        return self::write($filename, $text  ."\r\n", 'a');
    }

}
