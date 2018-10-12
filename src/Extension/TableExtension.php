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

use HtmlPurifier\Visitor\TableVisitor;
use HtmlPurifier\Visitor\TbodyVisitor;
use HtmlPurifier\Visitor\TdVisitor;
use HtmlPurifier\Visitor\TfootVisitor;
use HtmlPurifier\Visitor\TheadVisitor;
use HtmlPurifier\Visitor\ThVisitor;
use HtmlPurifier\Visitor\TrVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class TableExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'table';
    }

    public function getNodeVisitors(): array
    {
        return [
            'table' => TableVisitor::class,
            'tbody' => TbodyVisitor::class,
            'td' => TdVisitor::class,
            'tfoot' => TfootVisitor::class,
            'thead' => TheadVisitor::class,
            'th' => ThVisitor::class,
            'tr' => TrVisitor::class,
        ];
    }
}
