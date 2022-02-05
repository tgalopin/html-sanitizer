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

class DisabledStylesSanitizerTest extends AbstractSanitizerTest
{
    public function createSanitizer(): SanitizerInterface
    {
        return Sanitizer::create([
            'extensions' => ['basic'],
            'tags' => [
                'div' => [
                    'allowed_attributes' => []
                ],
                'p' => [
                    'allowed_attributes' => []
                ]
            ]
        ]);
    }

    public function provideFixtures(): array
    {
        return array_merge(parent::provideFixtures(), [
            [
                '<p style="text-align: center;">Lorem ipsum</p>',
                '<p>Lorem ipsum</p>',
            ],
            [
                '<div style="text-align: justify;">Lorem ipsum</div>',
                '<div>Lorem ipsum</div>',
            ],
        ]);
    }
}
