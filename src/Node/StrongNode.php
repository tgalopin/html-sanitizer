<?php

namespace HtmlPurifier\Node;

class StrongNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'strong';
    }
}
