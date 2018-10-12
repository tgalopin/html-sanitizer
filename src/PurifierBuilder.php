<?php

namespace HtmlPurifier;

use HtmlPurifier\Extension\ExtensionInterface;
use HtmlPurifier\Visitor\ScriptVisitor;
use HtmlPurifier\Visitor\StyleVisitor;
use HtmlPurifier\Visitor\TextVisitor;
use HtmlPurifier\Visitor\VisitorInterface;

class PurifierBuilder implements PurifierBuilderInterface
{
    /**
     * @var VisitorInterface[][]
     */
    private $nodeVisitors = [];

    public function registerExtension(ExtensionInterface $extension)
    {
        $this->nodeVisitors[$extension->getName()] = $extension->getNodeVisitors();
    }

    public function build(array $config): PurifierInterface
    {
        $nodeVisitors = [];

        foreach ($config['extensions'] ?? [] as $extensionName) {
            if (!isset($this->nodeVisitors[$extensionName])) {
                throw new \InvalidArgumentException(sprintf(
                    'You have requested a non-existent purifier extension "%s" (available extensions: %s)',
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

        return new Purifier(new DomVisitor($nodeVisitors));
    }
}
