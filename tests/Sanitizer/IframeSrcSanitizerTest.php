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

use HtmlSanitizer\Sanitizer\ImgSrcSanitizer;
use PHPUnit\Framework\TestCase;

class IframeSrcSanitizerTest extends TestCase
{
    public function provideDataUriForbidden()
    {
        $uris = [
            '/local/image.jpeg' => true,
            'https://trusted.com/image.jpeg' => true,
            'https://trusted.com/image.jpeg?query=1#foo' => true,
            'https://subdomain.trusted.com/image.jpeg' => true,

            'https://untrusted.com/image.jpeg' => false,
            'foo:invalid' => false,

            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,
            'data:text/plain;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Ensure https://bugs.php.net/bug.php?id=73192 is handled
            'https://untrusted.com:80?@trusted.com/' => false,
            'https://untrusted.com:80#@trusted.com/' => false,

            // Ensure https://medium.com/secjuice/php-ssrf-techniques-9d422cb28d51 is handled
            '0://untrusted.com;trusted.com' => false,
            '0://untrusted.com:80;trusted.com:80' => false,
            '0://untrusted.com:80,trusted.com:80' => false,
            'data:text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data://text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data:google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
            'data://google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
        ];

        foreach ($uris as $uri => $accepted) {
            yield [$uri, $accepted ? $uri : null];
        }

        // Ensure HTTP is rewritten to HTTPS
        yield ['http://trusted.com/image.jpeg', 'https://trusted.com/image.jpeg'];
    }

    /**
     * @dataProvider provideDataUriForbidden
     */
    public function testSanitizeDataUriForbidden($input, $expected)
    {
        $sanitizer = new ImgSrcSanitizer(['trusted.com'], false, true);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }

    public function provideDataUriAllowed()
    {
        $uris = [
            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => true,

            // Invalid URL
            'data:' => false,
            'data://image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Non-image content-type
            'data:text/plain;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,

            // Ensure https://medium.com/secjuice/php-ssrf-techniques-9d422cb28d51 is handled
            'data:text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data://text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data:google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
            'data://google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,

            // Ensure HTTP is kept
            'http://trusted.com/image.jpeg' => true,
        ];

        foreach ($uris as $uri => $accepted) {
            yield [$uri, $accepted ? $uri : null];
        }
    }

    /**
     * @dataProvider provideDataUriAllowed
     */
    public function testSanitizeDataUriAllowed($input, $expected)
    {
        $sanitizer = new ImgSrcSanitizer(['trusted.com'], true, false);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }
}
