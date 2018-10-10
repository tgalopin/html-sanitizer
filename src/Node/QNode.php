<?php

namespace HtmlPurifier\Node;

class QNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'q';
    }
}
