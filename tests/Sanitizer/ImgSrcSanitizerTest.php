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
use PHPUnit\Framework\TestCase;

class ImgSrcSanitizerTest extends TestCase
{
    public function provideUrls()
    {
        // Simple cases
        yield [
            'allowedHosts' => null,
            'allowDataUri' => false,
            'forceHttps' => false,
            'input' => 'https://trusted.com/image.php',
            'output' => 'https://trusted.com/image.php',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowDataUri' => false,
            'forceHttps' => false,
            'input' => 'https://trusted.com/image.php',
            'output' => 'https://trusted.com/image.php',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowDataUri' => false,
            'forceHttps' => false,
            'input' => 'https://untrusted.com/image.php',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => false,
            'forceHttps' => false,
            'input' => '/image.php',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => '/image.php',
            'output' => null,
        ];

        // Force HTTPS
        yield [
            'allowedHosts' => ['trusted.com'],
            'allowDataUri' => false,
            'forceHttps' => true,
            'input' => 'http://trusted.com/image.php',
            'output' => 'https://trusted.com/image.php',
        ];

        // Data-URI
        yield [
            'allowedHosts' => null,
            'allowDataUri' => false,
            'forceHttps' => false,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => 'data://image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => 'data:',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowDataUri' => true,
            'forceHttps' => false,
            'input' => 'data:text/plain;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testSanitize($allowedHosts, $allowDataUri, $forceHttps, $input, $expected)
    {
        $this->assertSame($expected, (new ImgSrcSanitizer($allowedHosts, $allowDataUri, $forceHttps))->sanitize($input));
    }
}
