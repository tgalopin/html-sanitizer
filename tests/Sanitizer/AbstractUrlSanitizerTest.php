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

use PHPUnit\Framework\TestCase;

abstract class AbstractUrlSanitizerTest extends TestCase
{
    protected function provideUrls()
    {
        return [
            'https://trusted.com/link.php' => true,
            'https://trusted.com/link.php?query=1#foo' => true,
            'https://subdomain.trusted.com/link' => true,
            '//trusted.com/link.php' => true,
            '/local/link' => true,
            'local/link' => true,

            'https:trusted.com/link.php' => false,
            'https://untrusted.com/link' => false,
            'foo:invalid' => false,

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
            'data://image/png;base64,SSBsb3ZlIFBIUAo=trusted.com' => false,
            'data:google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,
            'data://google.com/plain;base64,SSBsb3ZlIFBIUAo=' => false,

            // Inspired by https://github.com/punkave/sanitize-html/blob/master/test/test.js
            "java\0&#14;\t\r\n script:alert(\'foo\')" => false,
            "java&#0000001script:alert(\'foo\')" => false,
            "java&#0000000script:alert(\'foo\')" => false,
            'java<!-- -->script:alert(\'foo\')' => false,
        ];
    }
}
