<?php

namespace HtmlPurifier\Node;

class CaptionNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'caption';
    }
}
