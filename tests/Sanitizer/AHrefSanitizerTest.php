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

use HtmlSanitizer\Sanitizer\AHrefSanitizer;
use PHPUnit\Framework\TestCase;

class AHrefSanitizerTest extends TestCase
{
    public function provideMailToForbidden()
    {
        $uris = [
            '/local/link' => true,
            'https://trusted.com/link.php' => true,
            'https://trusted.com/link.php?query=1#foo' => true,
            'https://subdomain.trusted.com/link' => true,

            'https://untrusted.com/link' => false,
            'foo:invalid' => false,

            'mailto:test@gmail.com' => false,

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
    }

    /**
     * @dataProvider provideMailToForbidden
     */
    public function testSanitizeMailToForbidden($input, $expected)
    {
        $sanitizer = new AHrefSanitizer(['trusted.com'], false);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }

    public function provideMailToAllowed()
    {
        $uris = [
            'mailto:test@gmail.com' => true,

            // Invalid e-mail
            'mailto:' => false,
            'mailto:invalid' => false,

            // Ensure https://medium.com/secjuice/php-ssrf-techniques-9d422cb28d51 is handled
            'data:text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data://text/plain;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data:google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
            'data://google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
        ];

        foreach ($uris as $uri => $accepted) {
            yield [$uri, $accepted ? $uri : null];
        }
    }

    /**
     * @dataProvider provideMailToAllowed
     */
    public function testSanitizeMailToAllowed($input, $expected)
    {
        $sanitizer = new AHrefSanitizer(['trusted.com'], true);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }
}
