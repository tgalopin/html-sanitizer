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
use PHPUnit\Framework\TestCase;

class IframeSrcSanitizerTest extends TestCase
{
    public function provideUrls()
    {
        // Simple cases
        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => null,
            'forceHttps' => false,
            'input' => 'https://trusted.com/iframe.php',
            'output' => 'https://trusted.com/iframe.php',
        ];

        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => ['trusted.com'],
            'forceHttps' => false,
            'input' => 'https://trusted.com/iframe.php',
            'output' => 'https://trusted.com/iframe.php',
        ];

        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => ['trusted.com'],
            'forceHttps' => false,
            'input' => 'https://untrusted.com/iframe.php',
            'output' => null,
        ];

        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => null,
            'forceHttps' => false,
            'input' => '/iframe.php',
            'output' => null,
        ];

        // Force HTTPS
        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => ['trusted.com'],
            'forceHttps' => true,
            'input' => 'http://trusted.com/iframe.php',
            'output' => 'https://trusted.com/iframe.php',
        ];

        // Data-URI not allowed
        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => null,
            'forceHttps' => false,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        yield [
            'allowedSchemes' => ['http', 'https'],
            'allowedHosts' => null,
            'forceHttps' => true,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        yield [
            'allowedSchemes' => ['https'],
            'allowedHosts' => null,
            'forceHttps' => false,
            'input' => 'http://trusted.com/iframe.php',
            'output' => null,
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testSanitize($allowedSchemes, $allowedHosts, $forceHttps, $input, $expected)
    {
        $this->assertSame($expected, (new IframeSrcSanitizer($allowedSchemes, $allowedHosts, $forceHttps))->sanitize($input));
    }
}
