<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\TableVisitor;
use HtmlPurifier\Visitor\TbodyVisitor;
use HtmlPurifier\Visitor\TdVisitor;
use HtmlPurifier\Visitor\TfootVisitor;
use HtmlPurifier\Visitor\TheadVisitor;
use HtmlPurifier\Visitor\ThVisitor;
use HtmlPurifier\Visitor\TrVisitor;

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
