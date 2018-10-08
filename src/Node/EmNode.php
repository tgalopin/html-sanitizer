<?php

namespace HtmlPurifier\Node;

class EmNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'em';
    }
}
