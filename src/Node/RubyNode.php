<?php

namespace HtmlPurifier\Node;

class RubyNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'ruby';
    }
}
