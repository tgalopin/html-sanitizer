<?php

namespace HtmlPurifier\Node;

class AbbrNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'abbr';
    }
}
