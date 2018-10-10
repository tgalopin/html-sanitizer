<?php

namespace HtmlPurifier;

use HtmlPurifier\Parser\MastermindsParser;
use HtmlPurifier\Parser\ParserInterface;

class Purifier implements PurifierInterface
{
    /**
     * @var DomVisitorInterface
     */
    private $visitor;

    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(array $config = [], DomVisitorInterface $visitor = null, ParserInterface $parser = null)
    {
        $this->visitor = $visitor ?: $this->createVisitor($config);
        $this->parser = $parser ?: new MastermindsParser();
    }

    public function purify(string $html): string
    {
        try {
            $parsed = $this->parser->parse($html);
        } catch (\Exception $exception) {
            return '';
        }

        return $this->visitor->visit($parsed)->render();
    }

    private function createVisitor(array $config = []): DomVisitorInterface
    {
        $tags = $config['allowed_tags'] ?? [];
        if (!empty($config['presets'])) {
            $tags = array_merge($this->createPresetTagsConfig($config['presets']), $tags);
        }

        $visitors = array_filter([
            isset($tags['abbr']) ? new Visitor\AbbrVisitor($tags['abbr']) : null,
            isset($tags['a']) ? new Visitor\AVisitor($tags['a']) : null,
            isset($tags['blockquote']) ? new Visitor\BlockquoteVisitor($tags['blockquote']) : null,
            isset($tags['br']) ? new Visitor\BrVisitor($tags['br']) : null,
            isset($tags['caption']) ? new Visitor\CaptionVisitor($tags['caption']) : null,
            isset($tags['code']) ? new Visitor\CodeVisitor($tags['code']) : null,
            isset($tags['dd']) ? new Visitor\DdVisitor($tags['dd']) : null,
            isset($tags['del']) ? new Visitor\DelVisitor($tags['del']) : null,
            isset($tags['div']) ? new Visitor\DivVisitor($tags['div']) : null,
            isset($tags['dl']) ? new Visitor\DlVisitor($tags['dl']) : null,
            isset($tags['dt']) ? new Visitor\DtVisitor($tags['dt']) : null,
            isset($tags['em']) ? new Visitor\EmVisitor($tags['em']) : null,
            isset($tags['figcaption']) ? new Visitor\FigcaptionVisitor($tags['figcaption']) : null,
            isset($tags['figure']) ? new Visitor\FigureVisitor($tags['figure']) : null,
            isset($tags['h1']) ? new Visitor\H1Visitor($tags['h1']) : null,
            isset($tags['h2']) ? new Visitor\H2Visitor($tags['h2']) : null,
            isset($tags['h3']) ? new Visitor\H3Visitor($tags['h3']) : null,
            isset($tags['h4']) ? new Visitor\H4Visitor($tags['h4']) : null,
            isset($tags['h5']) ? new Visitor\H5Visitor($tags['h5']) : null,
            isset($tags['h6']) ? new Visitor\H6Visitor($tags['h6']) : null,
            isset($tags['hr']) ? new Visitor\HrVisitor($tags['hr']) : null,
            isset($tags['iframe']) ? new Visitor\IframeVisitor($tags['iframe']) : null,
            isset($tags['img']) ? new Visitor\ImgVisitor($tags['img']) : null,
            isset($tags['i']) ? new Visitor\IVisitor($tags['i']) : null,
            isset($tags['li']) ? new Visitor\LiVisitor($tags['li']) : null,
            isset($tags['ol']) ? new Visitor\OlVisitor($tags['ol']) : null,
            isset($tags['pre']) ? new Visitor\PreVisitor($tags['pre']) : null,
            isset($tags['p']) ? new Visitor\PVisitor($tags['p']) : null,
            isset($tags['q']) ? new Visitor\QVisitor($tags['q']) : null,
            isset($tags['rp']) ? new Visitor\RpVisitor($tags['rp']) : null,
            isset($tags['rt']) ? new Visitor\RtVisitor($tags['rt']) : null,
            isset($tags['ruby']) ? new Visitor\RubyVisitor($tags['ruby']) : null,
            isset($tags['small']) ? new Visitor\SmallVisitor($tags['small']) : null,
            isset($tags['span']) ? new Visitor\SpanVisitor($tags['span']) : null,
            isset($tags['strong']) ? new Visitor\StrongVisitor($tags['strong']) : null,
            isset($tags['sub']) ? new Visitor\SubVisitor($tags['sub']) : null,
            isset($tags['sup']) ? new Visitor\SupVisitor($tags['sup']) : null,
            isset($tags['table']) ? new Visitor\TableVisitor($tags['table']) : null,
            isset($tags['tbody']) ? new Visitor\TbodyVisitor($tags['tbody']) : null,
            isset($tags['td']) ? new Visitor\TdVisitor($tags['td']) : null,
            isset($tags['tfoot']) ? new Visitor\TfootVisitor($tags['tfoot']) : null,
            isset($tags['thead']) ? new Visitor\TheadVisitor($tags['thead']) : null,
            isset($tags['th']) ? new Visitor\ThVisitor($tags['th']) : null,
            isset($tags['tr']) ? new Visitor\TrVisitor($tags['tr']) : null,
            isset($tags['ul']) ? new Visitor\UlVisitor($tags['ul']) : null,

            new Visitor\StyleVisitor(),
            new Visitor\ScriptVisitor(),
            new Visitor\TextVisitor(),
        ]);

        return new DomVisitor($visitors);
    }

    private function createPresetTagsConfig(array $presets): array
    {
        $tags = [];

        if (in_array('basic', $presets, true)) {
            $tags = array_merge($tags, [
                'a' => [],
                'br' => [],
                'blockquote' => [],
                'div' => [],
                'del' => [],
                'em' => [],
                'figcaption' => [],
                'figure' => [],
                'h1' => [],
                'h2' => [],
                'h3' => [],
                'h4' => [],
                'h5' => [],
                'h6' => [],
                'i' => [],
                'p' => [],
                'q' => [],
                'small' => [],
                'span' => [],
                'strong' => [],
                'sub' => [],
                'sup' => [],
            ]);
        }

        if (in_array('code', $presets, true)) {
            $tags = array_merge($tags, [
                'code' => [],
                'pre' => [],
            ]);
        }

        if (in_array('image', $presets, true)) {
            $tags = array_merge($tags, [
                'img' => [],
            ]);
        }

        if (in_array('iframe', $presets, true)) {
            $tags = array_merge($tags, [
                'iframe' => [],
            ]);
        }

        if (in_array('list', $presets, true)) {
            $tags = array_merge($tags, [
                'dd' => [],
                'dl' => [],
                'dt' => [],
                'li' => [],
                'ol' => [],
                'ul' => [],
            ]);
        }

        if (in_array('table', $presets, true)) {
            $tags = array_merge($tags, [
                'table' => [],
                'tbody' => [],
                'td' => [],
                'tfoot' => [],
                'thead' => [],
                'th' => [],
                'tr' => [],
            ]);
        }

        if (in_array('extra', $presets, true)) {
            $tags = array_merge($tags, [
                'abbr' => [],
                'caption' => [],
                'hr' => [],
                'rp' => [],
                'rt' => [],
                'ruby' => [],
            ]);
        }

        return $tags;
    }
}
