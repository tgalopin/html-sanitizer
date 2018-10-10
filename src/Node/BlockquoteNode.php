<?php

namespace HtmlPurifier\Node;

class BlockquoteNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'blockquote';
    }
}
