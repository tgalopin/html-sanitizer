<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\BrNode;
use HtmlPurifier\Node\NodeInterface;

class BrVisitor extends AbstractVisitor
{
    use ChildlessTagVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'br';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new BrNode($cursor->node);
    }
}
