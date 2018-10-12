<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer;

use HtmlSanitizer\Extension\ExtensionInterface;
use HtmlSanitizer\Visitor\ScriptVisitor;
use HtmlSanitizer\Visitor\StyleVisitor;
use HtmlSanitizer\Visitor\TextVisitor;
use HtmlSanitizer\Visitor\VisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class SanitizerBuilder implements SanitizerBuilderInterface
{
    /**
     * @var VisitorInterface[][]
     */
    private $nodeVisitors = [];

    public function registerExtension(ExtensionInterface $extension)
    {
        $this->nodeVisitors[$extension->getName()] = $extension->getNodeVisitors();
    }

    public function build(array $config): SanitizerInterface
    {
        $nodeVisitors = [];

        foreach ($config['extensions'] ?? [] as $extensionName) {
            if (!isset($this->nodeVisitors[$extensionName])) {
                throw new \InvalidArgumentException(sprintf(
                    'You have requested a non-existent sanitizer extension "%s" (available extensions: %s)',
                    $extensionName,
                    implode(', ', array_keys($this->nodeVisitors))
                ));
            }

            foreach ($this->nodeVisitors[$extensionName] as $tagName => $className) {
                $nodeVisitors[$tagName] = new $className($config['tags'][$tagName] ?? []);
            }
        }

        // Always required visitors
        $nodeVisitors['script'] = new ScriptVisitor();
        $nodeVisitors['style'] = new StyleVisitor();
        $nodeVisitors['#text'] = new TextVisitor();

        return new Sanitizer(new DomVisitor($nodeVisitors));
    }
}
