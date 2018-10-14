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
class TextNode extends AbstractNode
{
    use IsChildlessTrait;

    private $text = '';

    public function __construct(NodeInterface $parent, string $text)
    {
        parent::__construct($parent);

        $this->text = $text;
    }

    public function render(): string
    {
        return htmlspecialchars($this->text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
