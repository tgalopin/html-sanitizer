<?php

namespace HtmlPurifier\Node;

class PreNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'pre';
    }
}
