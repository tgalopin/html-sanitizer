<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\AttributesNodeInterface;
use HtmlPurifier\Node\NodeInterface;

trait ChildrenTagVisitorTrait
{
    use TagVisitorTrait;

    abstract protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface;

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = $this->createNode($domNode, $cursor);
        if ($node instanceof AttributesNodeInterface && isset($this->config['allowed_attributes'])) {
            $this->setAttributes($domNode, $node, $this->config['allowed_attributes']);
        }

        $cursor->node->addChild($node);
        $cursor->node = $node;
    }

    public function leaveNode(\DOMNode $domNode, Cursor $cursor)
    {
        $cursor->node = $cursor->node->getParent();
    }
}
