<?php

namespace Tests\HtmlPurifier;

use HtmlPurifier\Purifier;
use PHPUnit\Framework\TestCase;

class PurifierTest extends TestCase
{
    public function provideFixtures()
    {
        yield ['safe'];
        yield ['scripts'];
    }

    /**
     * @dataProvider provideFixtures
     */
    public function testPurify($dir)
    {
        $input = $this->removeNewLines(file_get_contents(__DIR__.'/Fixtures/'.$dir.'/input.html'));
        $expectedOutput = $this->removeNewLines(file_get_contents(__DIR__.'/Fixtures/'.$dir.'/output.html'));

        $this->assertEquals($expectedOutput, $this->createPurifier()->purify($input));
    }

    private function removeNewLines(string $str): string
    {
        return trim(str_replace(["\n", "\r"], '', $str));
    }

    private function createPurifier(): Purifier
    {
        return Purifier::create([
            'allowed_tags' => [
                'a' => [
                    'allowed_hosts' => ['trusted.com'],
                    'allow_mailto' => true,
                    'force_target_blank' => ['except_hosts' => ['trusted.com']],
                ],
                'img' => [
                    'allowed_hosts' => ['trusted.com'],
                    'allow_data_uri' => false,
                    'force_https' => true,
                ],
                'br' => [],
                'del' => [],
                'div' => [],
                'em' => [],
                'figcaption' => [],
                'figure' => [],
                'p' => [],
                'strong' => [],
            ],
        ]);
    }
}
