<?php

namespace HtmlPurifier\Node;

/**
 * Special node to ignore scripts and all their content.
 */
class ScriptNode extends AbstractNode
{
    use TagNodeTrait;
    use ChildlessTrait;

    public function getTagName(): string
    {
        return 'script';
    }

    public function render(): string
    {
        return '';
    }
}
