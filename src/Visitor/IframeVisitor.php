<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\IframeNode;
use HtmlPurifier\Node\NodeInterface;
use HtmlPurifier\Sanitizer\IframeSrcSanitizer;

class IframeVisitor extends AbstractVisitor
{
    use ChildrenTagVisitorTrait;

    /**
     * @var IframeSrcSanitizer
     */
    private $srcSanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->srcSanitizer = new IframeSrcSanitizer($this->config['allowed_hosts'], $this->config['force_https']);
    }

    protected function getDomNodeName(): string
    {
        return 'iframe';
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [
            'src', 'width', 'height', 'frameborder', 'title',

            // YouTube integration
            'allow', 'allowfullscreen',
        ];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'allowed_hosts' => null,
            'force_https' => false,
        ];
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        $node = new IframeNode($cursor->node);
        $node->setAttribute('src', $this->srcSanitizer->sanitize($this->getAttribute($domNode, 'src')));

        return $node;
    }
}
