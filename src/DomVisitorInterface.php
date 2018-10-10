<?php

namespace HtmlPurifier;

use HtmlPurifier\Node\DocumentNode;

/**
 * Visit a parsed DOM node to create the equivalent purified DocumentNode.
 */
interface DomVisitorInterface
{
    public function visit(\DOMNode $node): DocumentNode;
}
