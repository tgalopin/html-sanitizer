<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Node\ANode;
use HtmlPurifier\Node\AttributesNodeInterface;

trait TagVisitorTrait
{
    abstract protected function getDomNodeName(): string;

    public function supports(\DOMNode $domNode, Cursor $cursor): bool
    {
        return $this->getDomNodeName() === $domNode->nodeName;
    }

    /**
     * Set attributes from a DOM node to a purified node.
     *
     * @param \DOMNode $domNode
     * @param AttributesNodeInterface $node
     * @param array $allowedAttributes
     */
    private function setAttributes(\DOMNode $domNode, AttributesNodeInterface $node, array $allowedAttributes = [])
    {
        if (!count($domNode->attributes)) {
            return;
        }

        /** @var \DOMAttr $attribute */
        foreach ($domNode->attributes as $attribute) {
            $name = strtolower($attribute->name);

            if (in_array($name, $allowedAttributes)) {
                $node->setAttribute($name, $attribute->value);
            }
        }
    }

    /**
     * Read the value of a DOMNode attribute.
     *
     * @param \DOMNode $domNode
     * @param string $name
     *
     * @return null|string
     */
    private function getAttribute(\DOMNode $domNode, string $name): ?string
    {
        if (!count($domNode->attributes)) {
            return null;
        }

        /** @var \DOMAttr $attribute */
        foreach ($domNode->attributes as $attribute) {
            if ($attribute->name === $name) {
                return $attribute->value;
            }
        }

        return null;
    }
}
