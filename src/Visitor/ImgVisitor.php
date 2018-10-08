<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ImgNode;

class ImgVisitor extends AbstractVisitor
{
    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'img' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [
            'src' => 'text',
            'alt' => 'text',
            'title' => 'text',
        ];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'trusted_hosts' => null,
            'allow_data_uri' => false,
        ];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new ImgNode($cursor->node);
        $this->setAttributes($domNode, $node);

        $cursor->node->addChild($node);
    }
}
