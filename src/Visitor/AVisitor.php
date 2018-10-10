<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ANode;
use HtmlPurifier\Sanitizer\AHrefSanitizer;

class AVisitor extends AbstractVisitor
{
    /**
     * @var AHrefSanitizer
     */
    private $hrefSanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->hrefSanitizer = new AHrefSanitizer($this->config['allowed_hosts'], $this->config['allow_mailto']);
    }

    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'a' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return ['href', 'title'];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'allowed_hosts' => null,
            'allow_mailto' => false,
            'force_target_blank' => null,
        ];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new ANode($cursor->node);
        $this->setAttributes($domNode, $node);
        $node->setAttribute('href', $this->hrefSanitizer->sanitize($node->getAttribute('href')));

        $cursor->node->addChild($node);
        $cursor->node = $node;
    }

    public function leaveNode(\DOMNode $domNode, Cursor $cursor)
    {
        $cursor->node = $cursor->node->getParent();
    }
}
