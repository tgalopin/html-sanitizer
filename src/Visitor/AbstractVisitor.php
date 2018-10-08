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

        $filters = $this->config['allowed_attributes'];

        /** @var \DOMAttr $attribute */
        foreach ($domNode->attributes as $attribute) {
            $name = strtolower($attribute->name);

            if (!isset($filters[$name])) {
                continue;
            }

            $sanitized = $this->normalize($attribute->value, $filters[$name], $name);
            if ($sanitized !== null) {
                $node->setAttribute($name, $sanitized);
            }
        }
    }

    private function normalize(string $value, string $filter, string $name): ?string
    {
        switch ($filter) {
            case 'int':
                return (string) ((int) $value);

            case 'bool':
                return $name;
        }

        return $value ? $value : null;
    }
}
