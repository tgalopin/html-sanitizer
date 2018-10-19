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

class AHrefSanitizerTest extends AbstractUrlSanitizerTest
{
    public function provideMailToForbidden()
    {
        $urls = array_merge($this->provideUrls(), [
            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,
            'mailto:test@gmail.com' => false,
            'mailto:' => false,
            'mailto:invalid' => false,
        ]);

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }
    }

    /**
     * @dataProvider provideMailToForbidden
     */
    public function testMailToForbidden($input, $expected)
    {
        $sanitizer = new AHrefSanitizer(['trusted.com'], false);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }

    public function provideMailToAllowed()
    {
        $urls = array_merge($this->provideUrls(), [
            'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' => false,
            'mailto:test@gmail.com' => true,
            'mailto:' => false,
            'mailto:invalid' => false,
        ]);

        foreach ($urls as $url => $accepted) {
            yield $url => [$url, $accepted ? $url : null];
        }
    }

    /**
     * @dataProvider provideMailToAllowed
     */
    public function testMailToAllowed($input, $expected)
    {
        $sanitizer = new AHrefSanitizer(['trusted.com'], true);
        $this->assertEquals($expected, $sanitizer->sanitize($input));
    }
}
