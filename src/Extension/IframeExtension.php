<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Extension;

use HtmlPurifier\Visitor\IframeVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class IframeExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'iframe';
    }

    public function getNodeVisitors(): array
    {
        return [
            'iframe' => IframeVisitor::class,
        ];
    }
}
