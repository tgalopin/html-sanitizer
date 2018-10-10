<?php

namespace HtmlPurifier\Node;

class TdNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'td';
    }
}
