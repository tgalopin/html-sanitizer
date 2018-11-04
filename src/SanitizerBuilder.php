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
use HtmlSanitizer\Visitor\ScriptNodeVisitor;
use HtmlSanitizer\Visitor\StyleNodeVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class SanitizerBuilder implements SanitizerBuilderInterface
{
    /**
     * @var ExtensionInterface[]
     */
    private $extensions = [];

    public function registerExtension(ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension;
    }

    public function build(array $config): SanitizerInterface
    {
        $nodeVisitors = [];

        foreach ($config['extensions'] ?? [] as $extensionName) {
            if (!isset($this->extensions[$extensionName])) {
                throw new \InvalidArgumentException(sprintf(
                    'You have requested a non-existent sanitizer extension "%s" (available extensions: %s)',
                    $extensionName,
                    implode(', ', array_keys($this->extensions))
                ));
            }

            foreach ($this->extensions[$extensionName]->createNodeVisitors($config) as $tagName => $visitor) {
                $nodeVisitors[$tagName] = $visitor;
            }
        }

        // Always required visitors
        $nodeVisitors['script'] = new ScriptNodeVisitor();
        $nodeVisitors['style'] = new StyleNodeVisitor();

        return new Sanitizer(new DomVisitor($nodeVisitors), $config['max_input_length'] ?? 20000);
    }
}
