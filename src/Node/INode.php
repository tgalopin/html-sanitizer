<?php

namespace HtmlPurifier\Node;

class INode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'i';
    }
}
