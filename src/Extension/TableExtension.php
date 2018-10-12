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

use HtmlSanitizer\Visitor\TableVisitor;
use HtmlSanitizer\Visitor\TbodyVisitor;
use HtmlSanitizer\Visitor\TdVisitor;
use HtmlSanitizer\Visitor\TfootVisitor;
use HtmlSanitizer\Visitor\TheadVisitor;
use HtmlSanitizer\Visitor\ThVisitor;
use HtmlSanitizer\Visitor\TrVisitor;

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
