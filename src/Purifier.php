<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier;

use HtmlPurifier\Extension\BasicExtension;
use HtmlPurifier\Extension\CodeExtension;
use HtmlPurifier\Extension\ExtraExtension;
use HtmlPurifier\Extension\IframeExtension;
use HtmlPurifier\Extension\ImageExtension;
use HtmlPurifier\Extension\ListExtension;
use HtmlPurifier\Extension\TableExtension;
use HtmlPurifier\Parser\MastermindsParser;
use HtmlPurifier\Parser\ParserInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class Purifier implements PurifierInterface
{
    /**
     * @var DomVisitorInterface
     */
    private $domVisitor;

    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(DomVisitorInterface $domVisitor, ParserInterface $parser = null)
    {
        $this->domVisitor = $domVisitor;
        $this->parser = $parser ?: new MastermindsParser();
    }

    /**
     * Quickly create an already configured purifier using the default builder.
     *
     * @param array $config
     *
     * @return PurifierInterface
     */
    public static function create(array $config): PurifierInterface
    {
        $builder = new PurifierBuilder();
        $builder->registerExtension(new BasicExtension());
        $builder->registerExtension(new ListExtension());
        $builder->registerExtension(new ImageExtension());
        $builder->registerExtension(new CodeExtension());
        $builder->registerExtension(new TableExtension());
        $builder->registerExtension(new IframeExtension());
        $builder->registerExtension(new ExtraExtension());

        return $builder->build($config);
    }

    public function purify(string $html): string
    {
        try {
            $parsed = $this->parser->parse($html);
        } catch (\Exception $exception) {
            return '';
        }

        return $this->domVisitor->visit($parsed)->render();
    }
}
