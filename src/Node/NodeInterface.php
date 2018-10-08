<?php

namespace HtmlPurifier\Node;

/**
 * Represents a node of the purified tree.
 */
interface NodeInterface
{
    /**
     * Return this node's parent node if it has one.
     *
     * @return NodeInterface|null
     */
    public function getParent(): ?NodeInterface;

    /**
     * Return whether this type of node can have children or not.
     *
     * @return bool
     */
    public function canHaveChildren(): bool;

    /**
     * Add a child to this node.
     *
     * @param NodeInterface $node
     */
    public function addChild(NodeInterface $node);

    /**
     * Render this node as a string.
     *
     * @return string
     */
    public function render(): string;
}
