<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\AbbrVisitor;
use HtmlPurifier\Visitor\CaptionVisitor;
use HtmlPurifier\Visitor\HrVisitor;
use HtmlPurifier\Visitor\RpVisitor;
use HtmlPurifier\Visitor\RtVisitor;
use HtmlPurifier\Visitor\RubyVisitor;

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
