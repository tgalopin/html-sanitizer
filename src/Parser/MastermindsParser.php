<?php

namespace HtmlPurifier\Parser;

use HtmlPurifier\Exception\ParsingFailedException;
use Masterminds\HTML5;

class MastermindsParser implements ParserInterface
{
    public function parse(string $html): \DOMNode
    {
        try {
            return (new HTML5())->loadHTMLFragment($html);
        } catch (\Throwable $t) {
            throw new ParsingFailedException($this, $t);
        }
    }
}
