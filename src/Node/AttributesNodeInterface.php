<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Node;

/**
 * Represents a node having attributes.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface AttributesNodeInterface
{
    public function setAttribute(string $name, string $value);
}
