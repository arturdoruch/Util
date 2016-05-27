<?php

namespace ArturDoruch\Util\Tests;

use ArturDoruch\Util\FileUtils;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class FileUtilsTest extends \PHPUnit_Framework_TestCase
{
    private $file;

    protected function setUp()
    {
        $this->file = __DIR__ . '/file.txt';
        @unlink($this->file);
    }

    public function testWriteToNewLine()
    {
        $data = 'foobar';
        FileUtils::writeToNewLine($this->file, $data);
        FileUtils::writeToNewLine($this->file, $data);

        $result = FileUtils::getFileContent($this->file);

        $this->assertEquals('foobar' . PHP_EOL . 'foobar' . PHP_EOL, $result);

        $result = FileUtils::getFileContent($this->file, true);
        $this->assertCount(2, $result);
    }

    /*public function testPutArrayContents()
    {
        $data = [
            'lorem ipsum',
            'foo',
            'bar'
        ];

        $data = implode(PHP_EOL, $data) . PHP_EOL;
        FileUtils::putContents($this->file, $data);

        $data = 'new line';
        FileUtils::writeToNewLine($this->file, $data);
    }*/
}
 