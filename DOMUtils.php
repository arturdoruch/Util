<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DOMUtils
{
    /**
     * Creates a new DOMXPath from HTML content.
     *
     * @param string $content HTML content.
     *
     * @return \DOMXPath
     */
    public static function createXPath($content)
    {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($content);

        return new \DOMXPath($dom);
    }

    /**
     * @param \DOMXPath|string $source
     * @param string           $query The xpath query.
     *
     * @return \DOMNodeList|\DOMElement[]|null
     */
    public static function getNodeList($source, $query)
    {
        if (is_string($source)) {
            $source = static::createXPath($source);
        } elseif (!$source instanceof \DOMXPath) {
            throw new \InvalidArgumentException(sprintf(
                    'Parameter $source must be type of string or instance of DOMXPath. But given "%s"', gettype($source)
                ));
        }

        $path = $source->query($query);

        return $path && $path->length > 0 ? $path : array();
    }

    /**
     * @param \DOMXPath|string $xpath
     * @param string           $query The xpath query.
     *
     * @return \DOMElement|null
     */
    public static function getNode($xpath, $query)
    {
        $path = static::getNodeList($xpath, $query);

        return !empty($path) ? $path->item(0) : null;
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
