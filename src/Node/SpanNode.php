<?php

namespace HtmlPurifier\Node;

class SpanNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'span';
    }
}
