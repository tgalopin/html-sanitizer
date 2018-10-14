<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Visitor;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Node\TextNode;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class TextNodeVisitor extends AbstractNodeVisitor
{
    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return '#text' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $cursor->node->addChild(new TextNode($cursor->node, $domNode->nodeValue));
    }
}
