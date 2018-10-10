<?php

namespace HtmlPurifier\Node;

class DdNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'dd';
    }
}
