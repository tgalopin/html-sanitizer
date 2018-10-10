<?php

namespace HtmlPurifier\Node;

class IframeNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'iframe';
    }
}
