<?php

namespace HtmlPurifier\Node;

trait ChildlessTrait
{
    public function canHaveChildren(): bool
    {
        return false;
    }

    public function addChild(NodeInterface $child)
    {
    }
}
