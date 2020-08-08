<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 * This file was added by : Rohit Kumar (https://github.com/rohitcoder)
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\MathMl\NodeVisitor;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Extension\MathMl\Node\mpaddedNode;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;
use HtmlSanitizer\Visitor\NamedNodeVisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class mpaddedNodeVisitor extends AbstractNodeVisitor implements NamedNodeVisitorInterface
{
    use HasChildrenNodeVisitorTrait;

    protected function getDomNodeName(): string
    {
        return 'mpadded';
    }

    public function getDefaultAllowedAttributes(): array
    {
        return  ['columnalign', 'accentunder', 'src', 'subscriptshift', 'infixlinebreakstyle', 'mslinethickness', 'close', 'rightoverhang', 'longdivstyle', 'linebreak', 'bevelled', 'overflow', 'xml:lang', 'leftoverhang', 'columnwidth', 'equalcolumns', 'id', 'fontfamily', 'separators', 'minlabelspacing', 'scriptlevel', 'height', 'occurrence', 'stackalign', 'color', 'cdgroup', 'veryverythickmathspace', 'rowspacing', 'name', 'other', 'order', 'macros', 'veryverythinmathspace', 'notation', 'columnspan', 'fence', 'valign', 'maxsize', 'indentshiftfirst', 'lspace', 'lquote', 'position', 'crossout', 'equalrows', 'altimg-height', 'voffset', 'dir', 'frame', 'denomalign', 'actiontype', 'mode', 'display', 'linethickness', 'maxwidth', 'length', 'columnlines', 'movablelimits', 'lineleading', 'scriptsizemultiplier', 'linebreakstyle', 'charalign', 'charspacing','rquote', 'altimg', 'verythinmathspace', 'rowlines', 'accent', 'groupalign', 'separator', 'mathbackground', 'nargs', 'indenttarget', 'verythickmathspace', 'mathsize', 'symmetric', 'edge', 'open', 'side', 'thinmathspace', 'fontstyle', 'encoding', 'selection', 'columnspacing', 'decimalpoint', 'style', 'stretchy', 'cd', 'scriptminsize', 'width', 'indentalignfirst', 'shift', 'index', 'linebreakmultchar', 'xml:space', 'scope', 'largeop', 'alttext', 'altimg-valign', 'base', 'closure', 'minsize', 'indentalign', 'framespacing', 'definitionURL', 'rspace', 'numalign', 'fontweight', 'class', 'rowalign', 'form', 'alignmentscope', 'align', '%XLINK.prefix;:type', 'depth', 'fontsize', 'type', 'background', 'displaystyle', 'superscriptshift', 'mediummathspace', 'rowspan', 'indentshiftlast', 'location', 'xref', 'altimg-width', 'thickmathspace', 'indentalignlast', 'mathcolor', 'indentshift', 'mathvariant', 'xmlns'];
    }
    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        return new mpaddedNode($cursor->node);
    }
}

