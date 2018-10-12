<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Visitor;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Node\ANode;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Sanitizer\AHrefSanitizer;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class AVisitor extends AbstractVisitor
{
    use ChildrenTagVisitorTrait;

    /**
     * @var AHrefSanitizer
     */
    private $hrefSanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->hrefSanitizer = new AHrefSanitizer($this->config['allowed_hosts'], $this->config['allow_mailto']);
    }

    protected function getDomNodeName(): string
    {
        return 'a';
    }

    public function getDefaultAllowedAttributes(): array
    {
        return ['href', 'title'];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'allowed_hosts' => null,
            'allow_mailto' => true,
            'force_target_blank' => null,
        ];
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        $node = new ANode($cursor->node);
        $node->setAttribute('href', $this->hrefSanitizer->sanitize($this->getAttribute($domNode, 'href')));

        return $node;
    }
}
