<?php

namespace HtmlPurifier\Node;

class TrNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'tr';
    }
}
