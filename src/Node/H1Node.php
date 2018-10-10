<?php

namespace HtmlPurifier\Node;

class H1Node extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'h1';
    }
}
