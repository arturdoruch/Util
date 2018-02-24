<?php

namespace ArturDoruch\Util\Json\Tests;

use ArturDoruch\Util\Json\Json;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @todo What expected result of decoded and encoded should be?
     */
    public function testNullJson()
    {
        $json = new Json(null);
    }

    /**
     * @expectedException \ArturDoruch\Util\Json\UnexpectedJsonException
     * @expectedExceptionMessage Syntax error
     * @expectedExceptionCode 4
     */
    public function testStringJsonException()
    {
        new Json('foo');
    }
}
