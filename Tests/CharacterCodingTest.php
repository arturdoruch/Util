<?php

namespace ArturDoruch\Util\Tests;

use ArturDoruch\Util\CharacterCoding;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class CharacterCodingTest extends \PHPUnit_Framework_TestCase
{

    public function getUTF8Fixtures()
    {
        return [
            ['Citroën', 'Citroën'],
            ['💳bank', 'bank'],
            ['漢字', '漢字'],
        ];
    }

    /**
     * @dataProvider getUTF8Fixtures
     */
    public function testCleanUTF8($string, $expected)
    {
        $this->assertEquals($expected, CharacterCoding::cleanUTF8($string));
    }

    public function getUnicodeFixtures()
    {
        return [
            ['\u00ed', 'í'],
            ['\u2605', '★'],
            ['\u20AC', '€'],
        ];
    }

    /**
     * @dataProvider getUnicodeFixtures
     */
    public function testDecodeUnicode($string, $expected)
    {
        $this->assertEquals($expected, CharacterCoding::decodeUnicode($string, 'UTF-16BE'));
    }
}
