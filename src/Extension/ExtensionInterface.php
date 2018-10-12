<?php

namespace HtmlPurifier\Extension;

/**
 * A purifier extension allows to easily add features to the purifier to handle specific tags.
 */
interface ExtensionInterface
{
    /**
     * Return this extension name, which will be used in the purifier configuration.
     */
    public function getName(): string;

    /**
     * Return a list of node visitor classes to register in the purifier and the tag handled by the visitor,
     * following the format: tagName => visitorClassname.
     *
     * For instance:
     *
     *      'strong' => StrongVisitor::class,
     *
     * @return string[]
     */
    public function getNodeVisitors(): array;
}
