<?php

namespace HtmlPurifier\Node;

/**
 * Root node of the purified HTML. Contains all the other nodes.
 */
class DocumentNode implements NodeInterface
{
    use ChildrenTrait;

    public function getParent(): ?NodeInterface
    {
        return null;
    }

    public function render(): string
    {
        return $this->renderChildren();
    }
}
