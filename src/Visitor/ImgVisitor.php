<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ImgNode;
use HtmlPurifier\Node\NodeInterface;
use HtmlPurifier\Sanitizer\ImgSrcSanitizer;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ImgVisitor extends AbstractVisitor
{
    use ChildlessTagVisitorTrait;

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

    protected function getDomNodeName(): string
    {
        return 'img';
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

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        $node = new ImgNode($cursor->node);
        $node->setAttribute('src', $this->srcSanitizer->sanitize($this->getAttribute($domNode, 'src')));

        return $node;
    }
}
