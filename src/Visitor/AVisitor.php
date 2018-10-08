<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ANode;

class AVisitor extends AbstractVisitor
{
    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'a' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [
            'href' => 'text',
            'title' => 'text',
        ];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new ANode($cursor->node);
        $this->setAttributes($domNode, $node);

        $cursor->node->addChild($node);
        $cursor->node = $node;
    }

    public function leaveNode(\DOMNode $domNode, Cursor $cursor)
    {
        $cursor->node = $cursor->node->getParent();
    }
}
