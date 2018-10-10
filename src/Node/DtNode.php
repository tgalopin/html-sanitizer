<?php

namespace HtmlPurifier\Node;

class DtNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'dt';
    }
}
