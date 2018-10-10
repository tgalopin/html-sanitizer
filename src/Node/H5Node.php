<?php

namespace HtmlPurifier\Node;

class H5Node extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'h5';
    }
}
