<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Node;

/**
 * Used by nodes which can't have children.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
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
