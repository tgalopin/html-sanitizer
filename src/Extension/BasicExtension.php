<?php

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\AVisitor;
use HtmlPurifier\Visitor\BlockquoteVisitor;
use HtmlPurifier\Visitor\BrVisitor;
use HtmlPurifier\Visitor\DelVisitor;
use HtmlPurifier\Visitor\DivVisitor;
use HtmlPurifier\Visitor\EmVisitor;
use HtmlPurifier\Visitor\FigcaptionVisitor;
use HtmlPurifier\Visitor\FigureVisitor;
use HtmlPurifier\Visitor\H1Visitor;
use HtmlPurifier\Visitor\H2Visitor;
use HtmlPurifier\Visitor\H3Visitor;
use HtmlPurifier\Visitor\H4Visitor;
use HtmlPurifier\Visitor\H5Visitor;
use HtmlPurifier\Visitor\H6Visitor;
use HtmlPurifier\Visitor\IVisitor;
use HtmlPurifier\Visitor\PVisitor;
use HtmlPurifier\Visitor\QVisitor;
use HtmlPurifier\Visitor\SmallVisitor;
use HtmlPurifier\Visitor\SpanVisitor;
use HtmlPurifier\Visitor\StrongVisitor;
use HtmlPurifier\Visitor\SubVisitor;
use HtmlPurifier\Visitor\SupVisitor;

class BasicExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'basic';
    }

    public function getNodeVisitors(): array
    {
        return [
            'a' => AVisitor::class,
            'br' => BrVisitor::class,
            'blockquote' => BlockquoteVisitor::class,
            'div' => DivVisitor::class,
            'del' => DelVisitor::class,
            'em' => EmVisitor::class,
            'figcaption' => FigcaptionVisitor::class,
            'figure' => FigureVisitor::class,
            'h1' => H1Visitor::class,
            'h2' => H2Visitor::class,
            'h3' => H3Visitor::class,
            'h4' => H4Visitor::class,
            'h5' => H5Visitor::class,
            'h6' => H6Visitor::class,
            'i' => IVisitor::class,
            'p' => PVisitor::class,
            'q' => QVisitor::class,
            'small' => SmallVisitor::class,
            'span' => SpanVisitor::class,
            'strong' => StrongVisitor::class,
            'sub' => SubVisitor::class,
            'sup' => SupVisitor::class,
        ];
    }
}
