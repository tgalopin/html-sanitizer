<?php

namespace HtmlPurifier\Node;

class DelNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'del';
    }
}
