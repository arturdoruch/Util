<?php

namespace ArturDoruch\Util\Json;

/**
 * Handles encode and decode JSON.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 *
 * @deprecated Use the "arturdoruch/json" component instead.
 */
class Json
{
    private $decoded;

    /**
     * @param string $json Encoded JSON.
     * @param bool $array If true decoded JSON will be an associative array, otherwise a stdClass object.
     */
    public function __construct($json, $array = true)
    {
        $this->decoded = json_decode($json, $array);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new UnexpectedJsonException($json);
        }
    }

    /**
     * Gets decoded JSON.
     *
     * @return mixed
     */
    public function getDecoded()
    {
        return $this->decoded;
    }

    /**
     * Gets encoded JSON.
     *
     * @param int $options Options to format output. See json_encode() $options.
     * @param int $depth   Expected recursion depth.
     *
     * @return string
     */
    public function getEncoded($options = JSON_PRETTY_PRINT, $depth = 512)
    {
        return json_encode($this->decoded, $options, $depth);
    }
}
