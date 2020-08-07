<?php

/*
 * This file is part of the HTML sanitizer project.
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 * This file was added by : Rohit Kumar (https://github.com/rohitcoder)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\MathMl\Node;

use HtmlSanitizer\Node\AbstractTagNode;
use HtmlSanitizer\Node\HasChildrenTrait;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class sechNode extends AbstractTagNode
{
    use HasChildrenTrait;

    public function getTagName(): string
    {
        return 'sech';
    }
}
