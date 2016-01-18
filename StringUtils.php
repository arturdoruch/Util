<?php
/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */

namespace ArturDoruch\Util;

class StringUtils
{
    /**
     * Translates string in camel case notation into underscore.
     * E.g. fooBar -> foo_bar
     *
     * @param string $string String in camel case notation
     *
     * @return string $string translated into underscore notation
     */
    public static function deCamelize($string)
    {
        return preg_replace_callback('/([A-Z])/', function($match) {
                return strtolower('_'.$match[1]);
            }, lcfirst($string));
    }

    /**
     * Translates string in underscore notation into camel case.
     * E.g. foo_bar -> fooBar
     *
     * @param string $string          String in underscore notation
     * @param bool   $upperCaseFirst  Make string first character uppercase
     *
     * @return string $string translated into camel case notation
     */
    public static function camelize($string, $upperCaseFirst = false)
    {
        if ($upperCaseFirst === true) {
            $string = ucfirst($string);
        }

        return preg_replace_callback('/_([a-z\d])/', function($match) {
                return strtoupper($match[1]);
            }, $string);
    }

    /**
     * Makes string more human readable. Replaces underscores "_" between words to space " ".
     * Sets first letter in string to uppercase, the rest to lowercase.
     *
     * @param string $string
     * @param bool   $upperCaseAllFirst If true first letter in every word will be uppercase.
     *
     * @return string
     */
    public static function humanize($string, $upperCaseAllFirst = false)
    {
        $string = ucfirst(strtolower(trim($string)));

        return preg_replace_callback('/([_\- ])([a-z])/', function($matches) use ($upperCaseAllFirst) {
                $word = $upperCaseAllFirst === true ? ucfirst($matches[2]) : $matches[2];

                return ($matches[1] === '-' ? '-' : ' ') . $word;
            }, $string);
    }

    /**
     * Converts string into ftp format.
     *
     * @param string $string
     * @param int    $length The length to which string should be truncated.
     *
     * @return string
     */
    public static function toFtpFormat($string, $length = null)
    {
        $string = preg_replace('@[\/\\\*\:\?"<>\|]*@', '', $string);
        $string = preg_replace('/[ ]{2,}/', ' ', $string);

        if ($length) {
            return substr($string, 0, $length);
        }

        return substr($string, 0);
    }

    /**
     * Converts characters with encoding type of Windows-1250 into UTF-8.
     *
     * @link http://konfiguracja.c0.pl/iso02vscp1250en.html
     * @link http://konfiguracja.c0.pl/webpl/index_en.html#examp
     *
     * @param string $string
     *
     * @return string
     */
    public static function convertW1250ToUTF8($string)
    {
        if (static::hasUTF8Encoding($string)) {
            return $string;
        }

        $map = array(
            chr(0x8A) => chr(0xA9),
            chr(0x8C) => chr(0xA6),
            chr(0x8D) => chr(0xAB),
            chr(0x8E) => chr(0xAE),
            chr(0x8F) => chr(0xAC),
            chr(0x9C) => chr(0xB6),
            chr(0x9D) => chr(0xBB),
            chr(0xA1) => chr(0xB7),
            chr(0xA5) => chr(0xA1),
            chr(0xBC) => chr(0xA5),
            chr(0x9F) => chr(0xBC),
            chr(0xB9) => chr(0xB1),
            chr(0x9A) => chr(0xB9),
            chr(0xBE) => chr(0xB5),
            chr(0x9E) => chr(0xBE),
            chr(0x80) => '&euro;',
            chr(0x82) => '&sbquo;',
            chr(0x84) => '&bdquo;',
            chr(0x85) => '&hellip;',
            chr(0x86) => '&dagger;',
            chr(0x87) => '&Dagger;',
            chr(0x89) => '&permil;',
            chr(0x8B) => '&lsaquo;',
            chr(0x91) => '&lsquo;',
            chr(0x92) => '&rsquo;',
            chr(0x93) => '&ldquo;',
            chr(0x94) => '&rdquo;',
            chr(0x95) => '&bull;',
            chr(0x96) => '&ndash;',
            chr(0x97) => '&mdash;',
            chr(0x99) => '&trade;',
            chr(0x9B) => '&rsquo;',
            chr(0xA6) => '&brvbar;',
            chr(0xA9) => '&copy;',
            chr(0xAB) => '&laquo;',
            chr(0xAE) => '&reg;',
            chr(0xB1) => '&plusmn;',
            chr(0xB5) => '&micro;',
            chr(0xB6) => '&para;',
            chr(0xB7) => '&middot;',
            chr(0xBB) => '&raquo;',
        );

        return html_entity_decode(mb_convert_encoding(strtr($string, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Checks if a string have UTF-8 character encoding.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function hasUTF8Encoding($string)
    {
        return !!mb_detect_encoding($string, 'UTF-8', true);
    }

}
 