<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Basic\NodeVisitor;

use HtmlSanitizer\Extension\Basic\Node\FigureNode;
use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;
use HtmlSanitizer\Visitor\NamedNodeVisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class FigureNodeVisitor extends AbstractNodeVisitor implements NamedNodeVisitorInterface
{
    use HasChildrenNodeVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'figure';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new FigureNode($cursor->node);
    }
}
