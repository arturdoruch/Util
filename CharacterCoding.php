<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class CharacterCoding
{
    /**
     * Checks if given string has UTF-8 encoding type.
     *
     * @param string $string
     * @param bool   $strict Specifies whether to use the strict encoding detection.
     *
     * @return bool
     */
    public static function isUTF8($string, $strict = false)
    {
        return (bool) mb_detect_encoding($string, 'UTF-8', $strict);
    }

    /**
     * Removes overly long 2 byte sequences, as well as characters above U+10000.
     * Code taken from https://webcollab.sourceforge.io/unicode.html
     *
     * @param string $string
     *
     * @return string
     */
    public static function cleanUTF8($string)
    {
        return preg_replace(
            '/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
            '|[\x00-\x7F][\x80-\xBF]+'.
            '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
            '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
            '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
            '', $string);
    }

    /**
     * Decodes unicode escape sequences like "\u00ed" to proper encoded characters.
     * Code taken from https://stackoverflow.com/a/2934602
     *
     * @param string $string
     * @param string $encoding Encoding type of given string, like UTF-16BE.
     *
     * @return string
     */
    public static function decodeUnicode($string, $encoding = 'UCS-2BE')
    {
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($matches) use ($encoding) {
            return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', $encoding);
        }, $string);
    }
}
