<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;

/**
 * A visitor visit supported DOM nodes to decide whether and how to include them in the final output.
 */
interface VisitorInterface
{
    /**
     * Whether this visitor supports the DOM node or not in the current context.
     *
     * @param \DOMNode $domNode
     * @param Cursor   $cursor
     *
     * @return bool
     */
    public function supports(\DOMNode $domNode, Cursor $cursor): bool;

    /**
     * Enter the DOM node.
     *
     * @param \DOMNode $domNode
     * @param Cursor   $cursor
     */
    public function enterNode(\DOMNode $domNode, Cursor $cursor);

    /**
     * Leave the DOM node.
     *
     * @param \DOMNode $domNode
     * @param Cursor   $cursor
     */
    public function leaveNode(\DOMNode $domNode, Cursor $cursor);
}
