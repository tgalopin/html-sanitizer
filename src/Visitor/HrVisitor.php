<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\HrNode;
use HtmlPurifier\Node\NodeInterface;

class HrVisitor extends AbstractVisitor
{
    use ChildlessTagVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'hr';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new HrNode($cursor->node);
    }
}
