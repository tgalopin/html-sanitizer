<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension;

use HtmlSanitizer\Visitor\AbbrVisitor;
use HtmlSanitizer\Visitor\CaptionVisitor;
use HtmlSanitizer\Visitor\HrVisitor;
use HtmlSanitizer\Visitor\RpVisitor;
use HtmlSanitizer\Visitor\RtVisitor;
use HtmlSanitizer\Visitor\RubyVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ExtraExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'extra';
    }

    public function getNodeVisitors(): array
    {
        return [
            'abbr' => AbbrVisitor::class,
            'caption' => CaptionVisitor::class,
            'hr' => HrVisitor::class,
            'rp' => RpVisitor::class,
            'rt' => RtVisitor::class,
            'ruby' => RubyVisitor::class,
        ];
    }
}
