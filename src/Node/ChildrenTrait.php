<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Node;

/**
 * Used by nodes which can have children.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
trait ChildrenTrait
{
    /**
     * @var NodeInterface[]
     */
    private $children = [];

    public function canHaveChildren(): bool
    {
        return true;
    }

    public function addChild(NodeInterface $child)
    {
        $this->children[] = $child;
    }

    private function renderChildren(): string
    {
        $rendered = '';
        foreach ($this->children as $child) {
            $rendered .= $child->render();
        }

        return $rendered;
    }
}
