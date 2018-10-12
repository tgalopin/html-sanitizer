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

use HtmlPurifier\Visitor\DdVisitor;
use HtmlPurifier\Visitor\DlVisitor;
use HtmlPurifier\Visitor\DtVisitor;
use HtmlPurifier\Visitor\LiVisitor;
use HtmlPurifier\Visitor\OlVisitor;
use HtmlPurifier\Visitor\UlVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ListExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'list';
    }

    public function getNodeVisitors(): array
    {
        return [
            'dd' => DdVisitor::class,
            'dl' => DlVisitor::class,
            'dt' => DtVisitor::class,
            'li' => LiVisitor::class,
            'ol' => OlVisitor::class,
            'ul' => UlVisitor::class,
        ];
    }
}
