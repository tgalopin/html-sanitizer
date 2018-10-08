<?php

namespace HtmlPurifier\Node;

class PNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'p';
    }
}
