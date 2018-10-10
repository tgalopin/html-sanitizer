<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\AttributesNodeInterface;

abstract class AbstractVisitor implements VisitorInterface
{
    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config = [])
    {
        $default = $this->getDefaultConfiguration();
        $default['allowed_attributes'] = $this->getDefaultAllowedAttributes();

        $this->config = array_merge($default, $config);
    }

    /**
     * Return this visitor default allowed attributes and their filters.
     *
     * @return array
     */
    abstract public function getDefaultAllowedAttributes(): array;

    /**
     * Return this visitor additional default configuration.
     * Can only be of depth 1 as it will be merged with the one provided by the user.
     *
     * @return array
     */
    public function getDefaultConfiguration(): array
    {
        return [];
    }

    public function enterNode(\DOMNode $domNode, Cursor $cursor)
    {
    }

    public function leaveNode(\DOMNode $domNode, Cursor $cursor)
    {
    }

    /**
     * Access, sanitize and set attributes from a DOM node to a purified node.
     *
     * @param \DOMNode $domNode
     * @param AttributesNodeInterface $node
     */
    protected function setAttributes(\DOMNode $domNode, AttributesNodeInterface $node)
    {
        if (!$domNode->attributes->count()) {
            return;
        }

        /** @var \DOMAttr $attribute */
        foreach ($domNode->attributes as $attribute) {
            $name = strtolower($attribute->name);

            if (in_array($name, $this->config['allowed_attributes'])) {
                $node->setAttribute($name, $attribute->value);
            }
        }
    }
}
