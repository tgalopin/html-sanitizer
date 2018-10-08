<?php

namespace Tests\HtmlPurifier;

use HtmlPurifier\Purifier;
use HtmlPurifier\Visitor;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
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
        return new Purifier([
            new Visitor\AVisitor(),
            new Visitor\BrVisitor(),
            new Visitor\DelVisitor(),
            new Visitor\DivVisitor(),
            new Visitor\EmVisitor(),
            new Visitor\FigcaptionVisitor(),
            new Visitor\FigureVisitor(),
            new Visitor\ImgVisitor(),
            new Visitor\PVisitor(),
            new Visitor\ScriptVisitor(),
            new Visitor\StrongVisitor(),
            new Visitor\TextVisitor(),
        ]);
    }
}
