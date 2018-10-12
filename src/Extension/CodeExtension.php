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

use HtmlSanitizer\Visitor\CodeVisitor;
use HtmlSanitizer\Visitor\PreVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class CodeExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'code';
    }

    public function getNodeVisitors(): array
    {
        return [
            'code' => CodeVisitor::class,
            'pre' => PreVisitor::class,
        ];
    }
}
