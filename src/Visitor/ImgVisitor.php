<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ImgNode;
use HtmlPurifier\Sanitizer\ImgSrcSanitizer;

class ImgVisitor extends AbstractVisitor
{
    /**
     * @var ImgSrcSanitizer
     */
    private $srcSanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->srcSanitizer = new ImgSrcSanitizer(
            $this->config['allowed_hosts'],
            $this->config['allow_data_uri'],
            $this->config['force_https']
        );
    }

    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return 'img' === $domNode->nodeName;
    }

    public function getDefaultAllowedAttributes(): array
    {
        return ['src', 'alt', 'title'];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'allowed_hosts' => null,
            'allow_data_uri' => false,
            'force_https' => false,
        ];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
        $node = new ImgNode($cursor->node);
        $this->setAttributes($domNode, $node);
        $node->setAttribute('src', $this->srcSanitizer->sanitize($node->getAttribute('src')));

        $cursor->node->addChild($node);
    }
}
