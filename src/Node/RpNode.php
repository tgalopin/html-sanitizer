<?php

namespace HtmlPurifier\Node;

class RpNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'rp';
    }
}
