<?php

namespace HtmlPurifier\Node;

class FigureNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'figure';
    }
}
