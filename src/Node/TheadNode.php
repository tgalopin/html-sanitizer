<?php

namespace HtmlPurifier\Node;

class TheadNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'thead';
    }
}
