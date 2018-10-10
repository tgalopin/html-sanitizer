<?php

namespace HtmlPurifier\Node;

class H6Node extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'h6';
    }
}
