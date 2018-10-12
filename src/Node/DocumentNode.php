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
 * Root node of the purified HTML. Contains all the other nodes.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
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
