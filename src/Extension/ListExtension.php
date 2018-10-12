<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\DdVisitor;
use HtmlPurifier\Visitor\DlVisitor;
use HtmlPurifier\Visitor\DtVisitor;
use HtmlPurifier\Visitor\LiVisitor;
use HtmlPurifier\Visitor\OlVisitor;
use HtmlPurifier\Visitor\UlVisitor;

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
