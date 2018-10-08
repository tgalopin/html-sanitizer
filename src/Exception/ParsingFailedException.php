<?php

namespace HtmlPurifier\Exception;

use HtmlPurifier\Parser\ParserInterface;

class ParsingFailedException extends \InvalidArgumentException
{
    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(ParserInterface $parser, \Throwable $previous = null)
    {
        parent::__construct('HTML parsing failed using parser '.get_class($parser), 0, $previous);

        $this->parser = $parser;
    }

    public function getParser(): ParserInterface
    {
        return $this->parser;
    }
}
