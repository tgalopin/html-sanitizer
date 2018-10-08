<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\BrNode;

class BrVisitor extends AbstractVisitor
{
    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'br' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new BrNode($cursor->node);
        $this->setAttributes($domNode, $node);

        $cursor->node->addChild($node);
    }
}
