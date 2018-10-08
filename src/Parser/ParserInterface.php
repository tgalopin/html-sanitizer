<?php

namespace HtmlPurifier\Parser;

use HtmlPurifier\Exception\ParsingFailedException;

/**
 * A parser transforms a HTML string into a tree of DOMNode objects.
 */
interface ParserInterface
{
    /**
     * Parse a given string and returns a DOMNode tree.
     * This method must throw a ParsingFailedException if parsing failed in order for
     * the purifier to catch it and return an empty string.
     *
     * @param string $html
     *
     * @return \DOMNode
     *
     * @throws ParsingFailedException When the parsing fails.
     */
    public function parse(string $html): \DOMNode;
}
