<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\HtmlSanitizer;

use HtmlSanitizer\Sanitizer;
use HtmlSanitizer\SanitizerBuilder;
use HtmlSanitizer\SanitizerInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractSanitizerTest extends TestCase
{
    abstract public function createSanitizer(): SanitizerInterface;

    abstract public function provideFixtures(): array;

    public function testRemoveNullByte()
    {
        $this->assertSame('Null byte', Sanitizer::create([])->sanitize("Null byte\0"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowInvalidExtension()
    {
        $builder = new SanitizerBuilder();
        $builder->build(['extensions' => ['invalid']]);
    }

    public function provideSanitizerInput()
    {
        foreach ($this->provideFixtures() as $fixture) {
            yield $fixture[0] => [$fixture[0], $fixture[1]];
        }
    }

    /**
     * @dataProvider provideSanitizerInput
     */
    public function testSanitize($input, $expectedOutput)
    {
        $this->assertEquals($expectedOutput, $this->createSanitizer()->sanitize($input));
    }
}
