<?php

namespace HtmlPurifier\Node;

class UlNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'ul';
    }
}
