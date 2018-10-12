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

use HtmlSanitizer\Visitor\DdVisitor;
use HtmlSanitizer\Visitor\DlVisitor;
use HtmlSanitizer\Visitor\DtVisitor;
use HtmlSanitizer\Visitor\LiVisitor;
use HtmlSanitizer\Visitor\OlVisitor;
use HtmlSanitizer\Visitor\UlVisitor;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ListExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'list';
    }

    public function getNodeVisitors(): array
    {
        return [
            'dd' => DdVisitor::class,
            'dl' => DlVisitor::class,
            'dt' => DtVisitor::class,
            'li' => LiVisitor::class,
            'ol' => OlVisitor::class,
            'ul' => UlVisitor::class,
        ];
    }
}
