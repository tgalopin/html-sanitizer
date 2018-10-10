<?php

namespace HtmlPurifier\Node;

class HrNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildlessTrait;

    public function getTagName(): string
    {
        return 'hr';
    }
}
