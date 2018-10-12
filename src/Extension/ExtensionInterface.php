<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension;

/**
 * A sanitizer extension allows to easily add features to the sanitizer to handle specific tags.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface ExtensionInterface
{
    /**
     * Return this extension name, which will be used in the sanitizer configuration.
     */
    public function getName(): string;

    /**
     * Return a list of node visitor classes to register in the sanitizer and the tag handled by the visitor,
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
