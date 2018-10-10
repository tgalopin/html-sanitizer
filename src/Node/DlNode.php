<?php

namespace HtmlPurifier\Node;

class DlNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'dl';
    }
}
