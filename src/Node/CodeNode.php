<?php

namespace HtmlPurifier\Node;

class CodeNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'code';
    }
}
