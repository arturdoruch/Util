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
     * @throws \Exception
     * @return array File content as array.
     */
    public static function getFileContent($fileName)
    {
        if (!file_exists($fileName)) {
            throw new \Exception('File "' . $fileName . '" was not found.');
        }

        return file($fileName);
    }


    public static function humanizeSize($size)
    {
        if ($size < 1024) {
            return $size . ' B';
        } else if ($size < 1048576) {
            return round($size / 1024, 2) . ' KB'; // sprintf('%01.2f', $size / 1024.0));
        } else if ($size >= 1048576 && $size < 1073741824) {
            return round($size / 1048576, 2) . ' MB'; // sprintf('%01.2f', $size / (1024.0 * 1024)));
        } else {
            return round($size / 1073741824, 2) . ' GB';  // sprintf('%01.2f', $size / (1024.0 * 1024 * 1024)));
        }
    }

    public static function rename($oldPath, $newPath)
    {
        if (file_exists($oldPath)) {
            return @rename($oldPath, $newPath);
        }

        return null;
    }


    public static function removeDir($path)
    {
        if (file_exists($path)) {
            return @rmdir($path);
        }

        return null;
    }

    public static function read($file)
    {
    	if ($handle = @fopen($file, 'r')) {
    		$text = fread($handle, filesize($file));
    		fclose($handle);
    		
    		return $text;
    	} else {
    		return false;
    	}
    }

    public static function write($file, $text, $mode = 'w')
    {
        if ($handle = @fopen($file, $mode)) {
    		fwrite($handle, $text);
    		fclose($handle);
            
    		return true;
    	} else {
    		return false;
    	}	
    }   

    public static function writeToNewLine($file, $text)
    {
        return static::write($file, $text."\r\n", 'a');    
    }

}
