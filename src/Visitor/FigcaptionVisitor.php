<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\FigcaptionNode;

class FigcaptionVisitor extends AbstractVisitor
{
    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'figcaption' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new FigcaptionNode($cursor->node);
        $this->setAttributes($domNode, $node);

        $cursor->node->addChild($node);
        $cursor->node = $node;
    }

    public function leaveNode(\DOMNode $domNode, Cursor $cursor)
    {
        $cursor->node = $cursor->node->getParent();
    }
}
