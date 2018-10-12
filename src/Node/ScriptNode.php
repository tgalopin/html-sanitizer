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
 * Special node to ignore scripts and all their content.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
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
