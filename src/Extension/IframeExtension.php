<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\IframeVisitor;

class IframeExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'iframe';
    }

    public function getNodeVisitors(): array
    {
        return [
            'iframe' => IframeVisitor::class,
        ];
    }
}
