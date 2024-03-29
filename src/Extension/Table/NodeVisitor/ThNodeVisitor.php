<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Table\NodeVisitor;

use HtmlSanitizer\Extension\Table\Node\ThNode;
use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;
use HtmlSanitizer\Visitor\NamedNodeVisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class ThNodeVisitor extends AbstractNodeVisitor implements NamedNodeVisitorInterface
{
    use HasChildrenNodeVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'th';
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new ThNode($cursor->node);
    }
}
