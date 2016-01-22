<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DOMUtils
{
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
