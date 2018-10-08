<?php

namespace HtmlPurifier\Node;

class FigcaptionNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildrenTrait;

    public function getTagName(): string
    {
        return 'figcaption';
    }
}
