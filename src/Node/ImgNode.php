<?php

namespace HtmlPurifier\Node;

class ImgNode extends AbstractNode implements AttributesNodeInterface
{
    use TagNodeTrait;
    use ChildlessTrait;

    public function getTagName(): string
    {
        return 'img';
    }
}
