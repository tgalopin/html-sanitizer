<?php

namespace HtmlPurifier\Node;

class SmallNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'small';
    }
}
