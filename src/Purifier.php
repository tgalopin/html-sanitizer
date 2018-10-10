<?php

namespace HtmlPurifier;

use HtmlPurifier\Node\DocumentNode;
use HtmlPurifier\Parser\MastermindsParser;
use HtmlPurifier\Parser\ParserInterface;
use HtmlPurifier\Model\Cursor;
use HtmlPurifier\Visitor\VisitorInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Purifier implements PurifierInterface
{
    /**
     * @var VisitorInterface[]
     */
    private $visitors;

    /**
     * @var VisitorInterface[]
     */
    private $reversedVisitors;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $visitors = [], ParserInterface $parser = null, LoggerInterface $logger = null)
    {
        $this->visitors = $visitors;
        $this->parser = $parser ?: new MastermindsParser();
        $this->logger = $logger ?: new NullLogger();
    }

    public function purify(string $html): string
    {
        if (!$this->reversedVisitors) {
            $this->reversedVisitors = array_reverse($this->visitors);
        }

        try {
            $parsed = $this->parser->parse($html);
        } catch (\Exception $exception) {
            $this->logger->warning('Purifier failed to parse an input', [
                'exception' => $exception,
                // Encode to avoid XSS at log display
                'input' => htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            ]);

            return '<div></div>';
        }

        $cursor = new Cursor();
        $cursor->node = new DocumentNode();

        $this->visit($parsed, $cursor);

        return $cursor->node->render();
    }

    public static function create(array $config = []): self
    {
        $tags = $config['allowed_tags'] ?? [];

        $visitors = array_filter([
            isset($tags['a']) ? new Visitor\AVisitor($tags['a']) : null,
            isset($tags['br']) ? new Visitor\BrVisitor($tags['br']) : null,
            isset($tags['del']) ? new Visitor\DelVisitor($tags['del']) : null,
            isset($tags['div']) ? new Visitor\DivVisitor($tags['div']) : null,
            isset($tags['em']) ? new Visitor\EmVisitor($tags['em']) : null,
            isset($tags['figcaption']) ? new Visitor\FigcaptionVisitor($tags['figcaption']) : null,
            isset($tags['figure']) ? new Visitor\FigureVisitor($tags['figure']) : null,
            isset($tags['img']) ? new Visitor\ImgVisitor($tags['img']) : null,
            isset($tags['p']) ? new Visitor\PVisitor($tags['p']) : null,
            isset($tags['strong']) ? new Visitor\StrongVisitor($tags['strong']) : null,

            new Visitor\ScriptVisitor(),
            new Visitor\TextVisitor(),
        ]);

        return new self($visitors, $config['parser'] ?? null, $config['logger'] ?? null);
    }

    private function visit(\DOMNode $node, Cursor $cursor)
    {
        foreach ($this->visitors as $visitor) {
            if ($visitor->supports($node, $cursor)) {
                $visitor->enterNode($node, $cursor);
            }
        }

        if ($cursor->node->canHaveChildren()) {
            foreach ($node->childNodes ?? [] as $k => $child) {
                $this->visit($child, $cursor);
            }
        }

        foreach ($this->reversedVisitors as $visitor) {
            if ($visitor->supports($node, $cursor)) {
                $visitor->leaveNode($node, $cursor);
            }
        }
    }
}
