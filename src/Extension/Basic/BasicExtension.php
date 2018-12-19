<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Basic;

use HtmlSanitizer\Extension\ExtensionInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class BasicExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'basic';
    }

    public function createNodeVisitors(array $config = []): array
    {
        return [
            'a' => new NodeVisitor\ANodeVisitor($config['tags']['a'] ?? []),
            'article' => new NodeVisitor\ArticleNodeVisitor($config['tags']['article'] ?? []),
            'aside' => new NodeVisitor\AsideNodeVisitor($config['tags']['aside'] ?? []),
            'blockquote' => new NodeVisitor\BlockquoteNodeVisitor($config['tags']['blockquote'] ?? []),
            'br' => new NodeVisitor\BrNodeVisitor($config['tags']['br'] ?? []),
            'div' => new NodeVisitor\DivNodeVisitor($config['tags']['div'] ?? []),
            'del' => new NodeVisitor\DelNodeVisitor($config['tags']['del'] ?? []),
            'em' => new NodeVisitor\EmNodeVisitor($config['tags']['em'] ?? []),
            'figcaption' => new NodeVisitor\FigcaptionNodeVisitor($config['tags']['figcaption'] ?? []),
            'figure' => new NodeVisitor\FigureNodeVisitor($config['tags']['figure'] ?? []),
            'footer' => new NodeVisitor\FooterNodeVisitor($config['tags']['footer'] ?? []),
            'h1' => new NodeVisitor\H1NodeVisitor($config['tags']['h1'] ?? []),
            'h2' => new NodeVisitor\H2NodeVisitor($config['tags']['h2'] ?? []),
            'h3' => new NodeVisitor\H3NodeVisitor($config['tags']['h3'] ?? []),
            'h4' => new NodeVisitor\H4NodeVisitor($config['tags']['h4'] ?? []),
            'h5' => new NodeVisitor\H5NodeVisitor($config['tags']['h5'] ?? []),
            'h6' => new NodeVisitor\H6NodeVisitor($config['tags']['h6'] ?? []),
            'header' => new NodeVisitor\HeaderNodeVisitor($config['tags']['header'] ?? []),
            'i' => new NodeVisitor\INodeVisitor($config['tags']['i'] ?? []),
            'main' => new NodeVisitor\MainNodeVisitor($config['tags']['main'] ?? []),
            'mark' => new NodeVisitor\MarkNodeVisitor($config['tags']['mark'] ?? []),
            'nav' => new NodeVisitor\NavNodeVisitor($config['tags']['nav'] ?? []),
            'p' => new NodeVisitor\PNodeVisitor($config['tags']['p'] ?? []),
            'q' => new NodeVisitor\QNodeVisitor($config['tags']['q'] ?? []),
            'section' => new NodeVisitor\SectionNodeVisitor($config['tags']['section'] ?? []),
            'small' => new NodeVisitor\SmallNodeVisitor($config['tags']['small'] ?? []),
            'span' => new NodeVisitor\SpanNodeVisitor($config['tags']['span'] ?? []),
            'strong' => new NodeVisitor\StrongNodeVisitor($config['tags']['strong'] ?? []),
            'sub' => new NodeVisitor\SubNodeVisitor($config['tags']['sub'] ?? []),
            'sup' => new NodeVisitor\SupNodeVisitor($config['tags']['sup'] ?? []),
            'time' => new NodeVisitor\TimeNodeVisitor($config['tags']['time'] ?? []),
        ];
    }
}
