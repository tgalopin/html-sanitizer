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

use HtmlSanitizer\Visitor\AVisitor;
use HtmlSanitizer\Visitor\BlockquoteVisitor;
use HtmlSanitizer\Visitor\BrVisitor;
use HtmlSanitizer\Visitor\DelVisitor;
use HtmlSanitizer\Visitor\DivVisitor;
use HtmlSanitizer\Visitor\EmVisitor;
use HtmlSanitizer\Visitor\FigcaptionVisitor;
use HtmlSanitizer\Visitor\FigureVisitor;
use HtmlSanitizer\Visitor\H1Visitor;
use HtmlSanitizer\Visitor\H2Visitor;
use HtmlSanitizer\Visitor\H3Visitor;
use HtmlSanitizer\Visitor\H4Visitor;
use HtmlSanitizer\Visitor\H5Visitor;
use HtmlSanitizer\Visitor\H6Visitor;
use HtmlSanitizer\Visitor\IVisitor;
use HtmlSanitizer\Visitor\PVisitor;
use HtmlSanitizer\Visitor\QVisitor;
use HtmlSanitizer\Visitor\SmallVisitor;
use HtmlSanitizer\Visitor\SpanVisitor;
use HtmlSanitizer\Visitor\StrongVisitor;
use HtmlSanitizer\Visitor\SubVisitor;
use HtmlSanitizer\Visitor\SupVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
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
