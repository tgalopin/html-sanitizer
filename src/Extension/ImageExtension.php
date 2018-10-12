<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\ImgVisitor;

class ImageExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'image';
    }

    public function getNodeVisitors(): array
    {
        return [
            'img' => ImgVisitor::class,
        ];
    }
}
