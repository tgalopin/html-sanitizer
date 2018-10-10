<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ANode;
use HtmlPurifier\Node\NodeInterface;
use HtmlPurifier\Sanitizer\AHrefSanitizer;

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
