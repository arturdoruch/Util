<?php

namespace ArturDoruch\Util\Json;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class UnexpectedJsonException extends \UnexpectedValueException
{
    /**
     * @var string
     */
    private $json;

    /**
     * @param string $json Invalid JSON.
     */
    public function __construct($json)
    {
        $this->json = $json;
        parent::__construct(ucfirst(json_last_error_msg()) . '.', json_last_error());
    }

    /**
     * @return string Invalid JSON.
     */
    public function getJson()
    {
        return $this->json;
    }
}
