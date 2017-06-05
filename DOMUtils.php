<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DOMUtils
{
    /**
     * Creates a new DOMXPath object from HTML code.
     *
     * @param string $html The HTML code.
     *
     * @return \DOMXPath
     */
    public static function createXPath($html)
    {
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($html);

        return new \DOMXPath($dom);
    }

    /**
     * @param \DOMXPath|string $source The DOMXPath object or html code.
     * @param string           $query The xpath query.
     *
     * @return \DOMNodeList|\DOMElement[]|null
     */
    public static function getNodeList($source, $query)
    {
        if (is_string($source)) {
            $source = self::createXPath($source);
        } elseif (!$source instanceof \DOMXPath) {
            throw new \InvalidArgumentException(sprintf(
                    'Parameter $source must be type of string or instance of DOMXPath. But given "%s"', gettype($source)
                ));
        }

        $path = $source->query($query);

        return $path && $path->length > 0 ? $path : array();
    }

    /**
     * @param \DOMXPath|string $source The DOMXPath object or html code.
     * @param string           $query The xpath query.
     *
     * @return \DOMElement|null
     */
    public static function getNode($source, $query)
    {
        $path = self::getNodeList($source, $query);

        return !empty($path) ? $path->item(0) : null;
    }

    /**
     * @param \DOMNode $node
     *
     * @return string
     */
    public static function getInnerHTML(\DOMNode $node)
    { 
        $innerHTML = ''; 
        $children = $node->childNodes;
    
        foreach ($children as $child) { 
            $innerHTML .= $node->ownerDocument->saveHTML($child);
        }
    
        return $innerHTML; 
    }

    /**
     * @param \DOMDocument $document
     * @param string       $className
     *
     * @return \DOMNodeList
     */
    public static function getElementsByClassName(\DOMDocument $document, $className)
    {
        $xpath = new \DOMXPath($document);
        
        return $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' ".$className." ')]");            
    }
}
