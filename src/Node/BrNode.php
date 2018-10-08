<?php

namespace HtmlPurifier\Node;

class BrNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildlessTrait;

    public function getTagName(): string
    {
        return 'br';
    }
}
