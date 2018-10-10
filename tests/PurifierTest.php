<?php

namespace Tests\HtmlPurifier;

use HtmlPurifier\Purifier;
use HtmlPurifier\PurifierInterface;
use PHPUnit\Framework\TestCase;

class PurifierTest extends TestCase
{
    public function provideFixtures()
    {
        yield 'safe' => ['safe'];
        yield 'scripts' => ['scripts'];
        yield 'links' => ['links'];
        yield 'style' => ['style'];
    }

    /**
     * @dataProvider provideFixtures
     */
    public function testPurify($dir)
    {
        $input = file_get_contents(__DIR__.'/Fixtures/'.$dir.'/input.html');
        $expectedOutput = file_get_contents(__DIR__.'/Fixtures/'.$dir.'/output.html');

        $this->assertEquals($expectedOutput, $this->createPurifier()->purify($input));
    }

    private function createPurifier(): PurifierInterface
    {
        return new Purifier([
            'presets' => ['basic', 'code', 'image', 'list', 'table', 'iframe', 'extra'],
            'allowed_tags' => [
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
    }
}
