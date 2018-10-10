<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\NodeInterface;
use HtmlPurifier\Node\StrongNode;

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
