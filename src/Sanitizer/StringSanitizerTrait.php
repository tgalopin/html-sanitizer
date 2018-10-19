<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Sanitizer;

/**
 * @internal
 */
trait StringSanitizerTrait
{
    public function encodeHtmlEntities(string $string): string
    {
        $string = htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        // "&#34;" is shorter than "&quot;"
        $string = str_replace('&quot;', '&#34;', $string);

        // Fix several potential issues in how browsers intepret attributes values
        foreach (['+', '=', '@', '`'] as $char) {
            $string = str_replace($char, '&#'.ord($char).';', $string);
        }

        return $string;
    }
}
