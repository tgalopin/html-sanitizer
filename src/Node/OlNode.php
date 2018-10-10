<?php

namespace HtmlPurifier\Node;

class OlNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'ol';
    }
}
