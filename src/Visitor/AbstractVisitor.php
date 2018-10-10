<?php

namespace HtmlPurifier\Visitor;

use HtmlPurifier\Model\Cursor;

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
    public function getDefaultAllowedAttributes(): array
    {
        return [];
    }

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
}
