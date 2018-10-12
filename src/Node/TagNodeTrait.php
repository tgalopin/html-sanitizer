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
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
trait TagNodeTrait
{
    use AttributesTrait;

    abstract public function getTagName(): string;

    abstract public function canHaveChildren(): bool;

    public function render(): string
    {
        $tag = $this->getTagName();

        if ($this->canHaveChildren()) {
            return '<'.$tag.$this->renderAttributes().'>'.$this->renderChildren().'</'.$tag.'>';
        }

        return '<'.$tag.$this->renderAttributes().' />';
    }
}
