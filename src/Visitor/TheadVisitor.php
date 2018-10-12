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
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Node\TheadNode;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class TheadVisitor extends AbstractVisitor
{
    use ChildrenTagVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'thead';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new TheadNode($cursor->node);
    }
}
