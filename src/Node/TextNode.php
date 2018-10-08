<?php

namespace HtmlPurifier\Node;

class TextNode extends AbstractNode
{
    use ChildlessTrait;

    private $text = '';

    public function __construct(NodeInterface $parent, string $text)
    {
        parent::__construct($parent);

        $this->text = $text;
    }

    public function render(): string
    {
        return htmlspecialchars($this->text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
