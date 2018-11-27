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
use HtmlSanitizer\Parser\ParserInterface;
use HtmlSanitizer\Visitor\ScriptNodeVisitor;
use HtmlSanitizer\Visitor\StyleNodeVisitor;
use Psr\Log\LoggerInterface;

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

    /**
     * @var ParserInterface|null
     */
    private $parser;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    public function registerExtension(ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension;
    }

    public function setParser(?ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function setLogger(?LoggerInterface $logger)
    {
        $this->logger = $logger;
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

        return new Sanitizer(new DomVisitor($nodeVisitors), $config['max_input_length'] ?? 20000, $this->parser, $this->logger);
    }
}
