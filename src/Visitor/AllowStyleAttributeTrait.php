<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Visitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
trait AllowStyleAttributeTrait
{
    protected function sanitizeStyleAttr(?string $style): ?string
    {
        if ($style === null)
            return null;
        $allowedStyles = [];
        $styles = explode(';', $style);
        foreach ($styles as $style)
        {
            $style = trim($style);
            if (preg_match('/^text-align\\s*:\\s*(left|center|right|justify)\\s*$/AD', $style))
                $allowedStyles[] = $style;
        }
        if (empty($allowedStyles))
            return null;
        return implode(';', $allowedStyles) . ';';
    }
}
