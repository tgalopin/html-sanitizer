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
use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase
{
    public function provideEmptySanitizerFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideEmptySanitizerFixtures
     */
    public function testEmptySanitizer($dir)
    {
        $input = file_get_contents(__DIR__ . '/Fixtures/empty/' . $dir . '/input.html');
        $expectedOutput = file_get_contents(__DIR__ . '/Fixtures/empty/' . $dir . '/output.html');

        $emptySanitizer = Sanitizer::create([]);

        $this->assertEquals($expectedOutput, $emptySanitizer->sanitize($input));
    }

    public function provideSimpleSanitizerFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'links' => ['links'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideSimpleSanitizerFixtures
     */
    public function testSimpleSanitizer($dir)
    {
        $input = file_get_contents(__DIR__ . '/Fixtures/simple/' . $dir . '/input.html');
        $expectedOutput = file_get_contents(__DIR__ . '/Fixtures/simple/' . $dir . '/output.html');

        $emptySanitizer = Sanitizer::create(['extensions' => ['basic']]);

        $this->assertEquals($expectedOutput, $emptySanitizer->sanitize($input));
    }

    public function provideFullSanitizerFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'links' => ['links'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideFullSanitizerFixtures
     */
    public function testFullSanitizer($dir)
    {
        $input = file_get_contents(__DIR__.'/Fixtures/full/'.$dir.'/input.html');
        $expectedOutput = file_get_contents(__DIR__.'/Fixtures/full/'.$dir.'/output.html');

        $fullSanitizer = Sanitizer::create([
            'extensions' => ['basic', 'code', 'image', 'list', 'table', 'iframe', 'extra'],
            'tags' => [
                'a' => [
                    'allowed_hosts' => ['trusted.com', 'external.com'],
                    'force_target_blank' => ['except_hosts' => ['trusted.com']],
                ],
                'img' => [
                    'allowed_hosts' => ['trusted.com'],
                    'force_https' => true,
                ],
            ],
        ]);

        $this->assertEquals($expectedOutput, $fullSanitizer->sanitize($input));
    }
}
