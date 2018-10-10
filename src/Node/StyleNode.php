<?php

namespace HtmlPurifier\Node;

/**
 * Special node to ignore styles and all their content.
 */
class StyleNode extends AbstractNode
{
    use TagNodeTrait;
    use ChildlessTrait;

    public function getTagName(): string
    {
        return 'style';
    }

    public function render(): string
    {
        return '';
    }
}
