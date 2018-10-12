<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\HtmlPurifier;

use HtmlPurifier\Purifier;
use PHPUnit\Framework\TestCase;

class PurifierTest extends TestCase
{
    public function provideEmptyPurifierFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideEmptyPurifierFixtures
     */
    public function testEmptyPurifier($dir)
    {
        $input = file_get_contents(__DIR__ . '/Fixtures/empty/' . $dir . '/input.html');
        $expectedOutput = file_get_contents(__DIR__ . '/Fixtures/empty/' . $dir . '/output.html');

        $emptyPurifier = Purifier::create([]);

        $this->assertEquals($expectedOutput, $emptyPurifier->purify($input));
    }

    public function provideSimplePurifierFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'links' => ['links'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideSimplePurifierFixtures
     */
    public function testSimplePurifier($dir)
    {
        $input = file_get_contents(__DIR__ . '/Fixtures/simple/' . $dir . '/input.html');
        $expectedOutput = file_get_contents(__DIR__ . '/Fixtures/simple/' . $dir . '/output.html');

        $emptyPurifier = Purifier::create(['extensions' => ['basic']]);

        $this->assertEquals($expectedOutput, $emptyPurifier->purify($input));
    }

    public function provideFullPurifierFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'links' => ['links'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideFullPurifierFixtures
     */
    public function testFullPurifier($dir)
    {
        $input = file_get_contents(__DIR__.'/Fixtures/full/'.$dir.'/input.html');
        $expectedOutput = file_get_contents(__DIR__.'/Fixtures/full/'.$dir.'/output.html');

        $fullPurifier = Purifier::create([
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

        $this->assertEquals($expectedOutput, $fullPurifier->purify($input));
    }
}
