<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Basic\NodeVisitor;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Extension\Basic\Node\ANode;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Extension\Basic\Sanitizer\AHrefSanitizer;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;
use HtmlSanitizer\Visitor\NamedNodeVisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class ANodeVisitor extends AbstractNodeVisitor implements NamedNodeVisitorInterface
{
    use HasChildrenNodeVisitorTrait;

    /**
     * @var AHrefSanitizer
     */
    private $sanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->sanitizer = new AHrefSanitizer(
            $this->config['allowed_schemes'],
            $this->config['allowed_hosts'],
            $this->config['allow_mailto'],
            $this->config['force_https']
        );
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
            'allowed_schemes' => ['http', 'https'],
            'allowed_hosts' => null,
            'allow_mailto' => true,
            'force_https' => false,
            'force_rel' => false,
            'force_target' => false
        ];
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        $node = new ANode($cursor->node);
        $node->setAttribute('href', $this->sanitizer->sanitize($this->getAttribute($domNode, 'href')));
        if (false !== $this->config['force_rel']) {
            $node->setAttribute('rel', $this->config['force_rel']);
        }
        if (false !== $this->config['force_target']) {
            $node->setAttribute('target', $this->config['force_target']);
        }

        return $node;
    }
}
