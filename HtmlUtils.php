<?php
/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */

namespace ArturDoruch\Util;


class HtmlUtils
{
    /**
     * @param string $html
     * @param bool   $removeImage
     *
     * @return string
     */
    public static function removeNoise($html, $removeImage = true)
    {
        $noise = array(
            '<!--.*-->',
            '<!\[CDATA\[[^\]]+\]\]>',
            '<\s*(script|noscript|iframe)[^>]*>[^>]*<\s*\/\s*\1\s*>',
            '<\s*(meta|input)[^>]+>',
            //<input type="image" src="/templates/maniacs_dle/images/send.png" name="image">
        );

        if ($removeImage === true) {
            $noise[] = '<\s*(img)[^>]+>';
        }

        foreach ($noise as $pattern) {
            $html = preg_replace("@{$pattern}@is", '', $html);
        }

        return $html;
    }

    /**
     * @param string $html
     *
     * @return string
     */
    public static function removeWhiteSpace($html)
    {
        return preg_replace('/(?<=>)\s+(?=<)|(?<=>)\s+(?!=<)|(?!<=>)\s+(?=<)/i', '', $html);
    }

    /**
     * @param \DOMNode $element
     *
     * @return string
     */
    public static function getInnerHTML(\DOMNode $element)
    { 
        $innerHTML = ''; 
        $children = $element->childNodes;
    
        foreach ($children as $child) { 
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }
    
        return $innerHTML; 
    }

    /**
     * @param \DOMDocument $dom
     * @param string       $className
     *
     * @return \DOMNodeList
     */
    public static function getElementsByClassName(\DOMDocument $dom, $className)
    {
        $xpath = new \DOMXPath($dom);
        
        return $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' ".$className." ')]");            
    }       
    
}
