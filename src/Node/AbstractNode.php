<?php

namespace HtmlPurifier\Node;

abstract class AbstractNode implements NodeInterface
{
    private $parent;

    public function __construct(NodeInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): ?NodeInterface
    {
        return $this->parent;
    }
}
