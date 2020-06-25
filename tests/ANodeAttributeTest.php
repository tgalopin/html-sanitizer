<?php
namespace Tests\HtmlSanitizer;


use HtmlSanitizer\Sanitizer;
use PHPUnit\Framework\TestCase;

class ANodeAttributeTest extends TestCase {

    public function testForceRelAttribute()
    {
        $sanitizer = Sanitizer::create([
            'extensions' => ['basic'],
            'tags' => [
                'a' => [
                    'force_rel' => 'nofollow noopener'
                ]
            ]
        ]);

        $tests = [
            [
                '<a href="https://trusted.com" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" rel="nofollow noopener" title="Link title">Lorem ipsum</a>'
            ],
            [
                '<a href="https://trusted.com" rel="somethinginvalid" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" rel="nofollow noopener" title="Link title">Lorem ipsum</a>'
            ],
            [
                '<a href="https://trusted.com" rel="nofollow noopener" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" rel="nofollow noopener" title="Link title">Lorem ipsum</a>'
            ],
        ];

        foreach($tests as $testCase) {
            $this->assertSame( $testCase[1], $sanitizer->sanitize( $testCase[0] ) );
        }
    }

    public function testForceTargetAttribute()
    {
        $sanitizer = Sanitizer::create([
            'extensions' => ['basic'],
            'tags' => [
                'a' => [
                    'force_target' => '_blank'
                ]
            ]
        ]);

        $tests = [
            [
                '<a href="https://trusted.com" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" target="_blank" title="Link title">Lorem ipsum</a>'
            ],
            [
                '<a href="https://trusted.com" target="_self" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" target="_blank" title="Link title">Lorem ipsum</a>'
            ],
            [
                '<a href="https://trusted.com" target="_blank" title="Link title">Lorem ipsum</a>',
                '<a href="https://trusted.com" target="_blank" title="Link title">Lorem ipsum</a>'
            ],
        ];

        foreach($tests as $testCase) {
            $this->assertSame( $testCase[1], $sanitizer->sanitize( $testCase[0] ) );
        }
    }

}
