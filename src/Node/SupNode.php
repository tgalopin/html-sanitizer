<?php

namespace HtmlPurifier\Node;

class SupNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'sup';
    }
}
