<?php

namespace ArturDoruch\Util\Tests;

use ArturDoruch\Util\StringUtils;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class StringUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testCountUppercase()
    {
        $string = 'This Is a string with a Few Uppercase LETters';

        $result = StringUtils::countUppercaseLetters($string);
        $this->assertEquals(7, $result);
    }


    public function testCountUppercaseWords()
    {
        $string = 'THIS is a String with A Few capital Words.';
        $result = StringUtils::countUppercaseWords($string);

        $this->assertEquals(4, $result);

        $string = 'tHis_is_a_String_with_UnderScore\'s_and_8_Digit';
        $result = StringUtils::countUppercaseWords($string);

        $this->assertEquals(3, $result);
    }
}
 