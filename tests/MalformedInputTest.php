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
use HtmlSanitizer\SanitizerInterface;
use PHPUnit\Framework\TestCase;

class MalformedInputTest extends TestCase
{
    public function testSanitizeMalformedString()
    {
        $input = "<p>Apr\u00e8s s&#039;il y a un gros bug et que tout le monde en profite, mon avis l\u00e0 dessus peut changer. Mais normalement non, pas de reset pour les joueurs arriv\u00e9s avec la beta publique.<\/p>\n\n<p>Par contre certains \u00e9quilibrages changeront, c&#";

        $this->assertEquals('', $this->createSanitizer()->sanitize($input));
    }

    public function testSanitizeMalformedUrl()
    {
        // Use rtrim to remove end line should be able to change without consequence on the validity of the test
        $input = rtrim(file_get_contents(__DIR__.'/Fixtures/malformed/input.html'));
        $expectedOutput = rtrim(file_get_contents(__DIR__.'/Fixtures/malformed/output.html'));

        $this->assertEquals($expectedOutput, $this->createSanitizer()->sanitize($input));
    }

    private function createSanitizer(): SanitizerInterface
    {
        return Sanitizer::create(['extensions' => ['basic', 'code', 'image', 'list', 'table', 'iframe', 'extra']]);
    }
}
