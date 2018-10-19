<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\HtmlSanitizer\Sanitizer;

use HtmlSanitizer\Extension\Iframe\Sanitizer\IframeSrcSanitizer;

class IframeSrcSanitizerTest extends AbstractUrlSanitizerTest
{
    public function provideForceHttps()
    {
        $urls = $this->provideUrls();

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }

        // Ensure HTTP is rewritten to HTTPS
        yield 'http://trusted.com/image.jpeg' => ['http://trusted.com/image.jpeg', 'https://trusted.com/image.jpeg'];
    }

    /**
     * @dataProvider provideForceHttps
     */
    public function testForceHttps($input, $expected)
    {
        $sanitizer = new IframeSrcSanitizer(['trusted.com'], true);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }

    public function provideDontForceHttps()
    {
        $urls = $this->provideUrls();

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }

        // Ensure HTTP is kept
        yield 'http://trusted.com/image.jpeg' => ['http://trusted.com/image.jpeg', 'http://trusted.com/image.jpeg'];
    }

    /**
     * @dataProvider provideDontForceHttps
     */
    public function testDontForceHttps($input, $expected)
    {
        $sanitizer = new IframeSrcSanitizer(['trusted.com'], false);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }
}
