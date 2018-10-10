<?php

namespace HtmlPurifier\Node;

class SubNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'sub';
    }
}
