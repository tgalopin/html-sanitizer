<?php

namespace HtmlPurifier\Node;

/**
 * Used by nodes which can't have children.
 */
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
