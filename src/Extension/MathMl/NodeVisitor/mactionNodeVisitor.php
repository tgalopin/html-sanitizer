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
use HtmlSanitizer\Extension\MathMl\Node\MactionNode;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Extension\MathMl\Sanitizer\MactionSanitizer;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;
use HtmlSanitizer\Visitor\NamedNodeVisitorInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class MactionNodeVisitor extends AbstractNodeVisitor implements NamedNodeVisitorInterface
{
    use HasChildrenNodeVisitorTrait;

    /**
     * @var mactionSanitizer
     */
    private $sanitizer;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->sanitizer = new MactionSanitizer(
            $this->config['allowed_schemes'],
            $this->config['allowed_hosts'],
            $this->config['allow_mailto'],
            $this->config['force_https']
        );
    }

    protected function getDomNodeName(): string
    {
        return 'maction';
    }

    public function getDefaultAllowedAttributes(): array
    {
        return  ['columnalign', 'accentunder', 'src', 'subscriptshift', 'infixlinebreakstyle', 'mslinethickness', 'close', 'rightoverhang', 'longdivstyle', 'linebreak', 'bevelled', 'overflow', 'xml:lang', 'leftoverhang', 'columnwidth', 'equalcolumns', 'id', 'fontfamily', 'separators', 'minlabelspacing', 'scriptlevel', 'height', 'occurrence', 'stackalign', 'color', 'cdgroup', 'veryverythickmathspace', 'rowspacing', 'name', 'other', 'order', 'macros', 'veryverythinmathspace', 'notation', 'columnspan', 'fence', 'valign', 'maxsize', 'indentshiftfirst', 'lspace', 'lquote', 'position', 'crossout', 'equalrows', 'altimg-height', 'voffset', 'dir', 'frame', 'denomalign', 'actiontype', 'mode', 'display', 'linethickness', 'maxwidth', 'length', 'columnlines', 'movablelimits', 'lineleading', 'scriptsizemultiplier', 'linebreakstyle', 'charalign', 'charspacing', 'rquote', 'altimg', 'verythinmathspace', 'xlink:href', 'rowlines', 'accent', 'groupalign', 'separator', 'mathbackground', 'nargs', 'indenttarget', 'verythickmathspace', 'mathsize', 'symmetric', 'edge', 'open', 'side', 'thinmathspace', 'fontstyle', 'encoding', 'selection', 'columnspacing', 'decimalpoint', 'style', 'stretchy', 'cd', 'scriptminsize', 'width', 'indentalignfirst', 'shift', 'index', 'linebreakmultchar', 'xml:space', 'scope', 'largeop', 'alttext', 'altimg-valign', 'base', 'closure', 'minsize', 'indentalign', 'framespacing', 'definitionURL', 'rspace', 'numalign', 'fontweight', 'class', 'rowalign', 'form', 'alignmentscope', 'align', 'depth', 'fontsize', 'type', 'background', 'displaystyle', 'superscriptshift', 'mediummathspace', 'rowspan', 'indentshiftlast', 'location', 'xref', 'altimg-width', 'thickmathspace', 'indentalignlast', 'mathcolor', 'indentshift', 'mathvariant', 'xmlns'];
    }
    
    public function getDefaultConfiguration(): array
    {
        return [
            'allowed_schemes' => ['http', 'https'],
            'allowed_hosts' => null,
            'allow_mailto' => true,
            'force_https' => false,
        ];
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {        
        $node = new MactionNode($cursor->node);
        $node->setAttribute('xlink:href', $this->sanitizer->sanitize($this->getAttribute($domNode, 'xlink:href')));
        
        return $node; 
    }
}
