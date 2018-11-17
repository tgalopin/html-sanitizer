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

use HtmlSanitizer\Extension\Basic\Sanitizer\AHrefSanitizer;
use PHPUnit\Framework\TestCase;

class AHrefSanitizerTest extends TestCase
{
    public function provideUrls()
    {
        // Simple cases
        yield [
            'allowedHosts' => null,
            'allowMailTo' => false,
            'forceHttps' => false,
            'input' => 'https://trusted.com/link.php',
            'output' => 'https://trusted.com/link.php',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowMailTo' => false,
            'forceHttps' => false,
            'input' => 'https://trusted.com/link.php',
            'output' => 'https://trusted.com/link.php',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowMailTo' => false,
            'forceHttps' => false,
            'input' => 'https://untrusted.com/link.php',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => false,
            'forceHttps' => false,
            'input' => '/link.php',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => '/link.php',
            'output' => null,
        ];

        // Force HTTPS
        yield [
            'allowedHosts' => ['trusted.com'],
            'allowMailTo' => false,
            'forceHttps' => true,
            'input' => 'http://trusted.com/link.php',
            'output' => 'https://trusted.com/link.php',
        ];

        // Data-URI not allowed
        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => true,
            'input' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            'output' => null,
        ];

        // MailTo
        yield [
            'allowedHosts' => null,
            'allowMailTo' => false,
            'forceHttps' => false,
            'input' => 'mailto:test@gmail.com',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => 'mailto:test@gmail.com',
            'output' => 'mailto:test@gmail.com',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => 'mailto:test@gmail.com',
            'output' => 'mailto:test@gmail.com',
        ];

        yield [
            'allowedHosts' => ['trusted.com'],
            'allowMailTo' => true,
            'forceHttps' => true,
            'input' => 'mailto:test@gmail.com',
            'output' => 'mailto:test@gmail.com',
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => 'mailto:invalid',
            'output' => null,
        ];

        yield [
            'allowedHosts' => null,
            'allowMailTo' => true,
            'forceHttps' => false,
            'input' => 'mailto:',
            'output' => null,
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testSanitize($allowedHosts, $allowMailTo, $forceHttps, $input, $expected)
    {
        $this->assertSame($expected, (new AHrefSanitizer($allowedHosts, $allowMailTo, $forceHttps))->sanitize($input));
    }
}
