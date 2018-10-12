<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\CodeVisitor;
use HtmlPurifier\Visitor\PreVisitor;

class CodeExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'code';
    }

    public function getNodeVisitors(): array
    {
        return [
            'code' => CodeVisitor::class,
            'pre' => PreVisitor::class,
        ];
    }
}
