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

use HtmlSanitizer\Extension\Image\Sanitizer\ImgSrcSanitizer;

class ImgSrcSanitizerTest extends AbstractUrlSanitizerTest
{
    public function provideDataUriForbiddenForceHttps()
    {
        $urls = array_merge($this->provideUrls(), [
            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Invalid URL
            'data:' => false,
            'data://image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Non-image content-type
            'data:text/plain;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,
        ]);

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }

        // Ensure HTTP is rewritten to HTTPS
        yield 'http://trusted.com/image.jpeg' => ['http://trusted.com/image.jpeg', 'https://trusted.com/image.jpeg'];
    }

    /**
     * @dataProvider provideDataUriForbiddenForceHttps
     */
    public function testDataUriForbiddenForceHttps($input, $expected)
    {
        $sanitizer = new ImgSrcSanitizer(['trusted.com'], false, true);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }

    public function provideDataUriAllowedDontForceHttps()
    {
        $urls = array_merge($this->provideUrls(), [
            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => true,

            // Invalid URL
            'data:' => false,
            'data://image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Non-image content-type
            'data:text/plain;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,
        ]);

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }

        // Ensure HTTP is kept
        yield 'http://trusted.com/image.jpeg' => ['http://trusted.com/image.jpeg', 'http://trusted.com/image.jpeg'];
    }

    /**
     * @dataProvider provideDataUriAllowedDontForceHttps
     */
    public function testDataUriAllowedDontForceHttps($input, $expected)
    {
        $sanitizer = new ImgSrcSanitizer(['trusted.com'], true, false);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }
}
