<?php

namespace HtmlPurifier\Node;

class ANode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'a';
    }
}
