<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\NodeInterface;
use HtmlPurifier\Node\StrongNode;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class StrongVisitor extends AbstractVisitor
{
    use ChildrenTagVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'strong';
    }

    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'strong' === $domNode->nodeName || 'b' === $domNode->nodeName;
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new StrongNode($cursor->node);
    }
}
