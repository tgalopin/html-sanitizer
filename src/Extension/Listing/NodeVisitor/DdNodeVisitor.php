<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Listing\NodeVisitor;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Extension\Listing\Node\DdNode;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class DdNodeVisitor extends AbstractNodeVisitor
{
    use HasChildrenNodeVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'dd';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new DdNode($cursor->node);
    }
}
