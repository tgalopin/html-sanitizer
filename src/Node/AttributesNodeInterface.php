<?php

namespace HtmlPurifier\Node;

/**
 * Represents a node having attributes.
 */
interface AttributesNodeInterface
{
    public function setAttribute(string $name, string $value);
}
