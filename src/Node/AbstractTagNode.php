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
 * Abstract base class for tags.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
abstract class AbstractTagNode extends AbstractNode implements TagNodeInterface
{
    private $attributes = [];

    /**
     * Return this tag name (used to render it).
     *
     * @return string
     */
    abstract public function getTagName(): string;

    public function getAttribute(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function setAttribute(string $name, ?string $value)
    {
        // Always use only the first declaration (ease sanitization)
        if (!array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $value;
        }
    }

    public function render(): string
    {
        $tag = $this->getTagName();

        if (method_exists($this, 'renderChildren')) {
            return '<'.$tag.$this->renderAttributes().'>'.$this->renderChildren().'</'.$tag.'>';
        }

        return '<'.$tag.$this->renderAttributes().' />';
    }

    protected function renderAttributes(): string
    {
        $rendered = [];
        foreach ($this->attributes as $name => $value) {
            if ($value === null) {
                // Tag should be removed as a sanitizer found suspect data inside
                continue;
            }

            $attr = $name;
            if ($value !== '') {
                $attr .= '="'.$value.'"';
            }

            $rendered[] = $attr;
        }

        return $rendered ? ' '.implode(' ', $rendered) : '';
    }
}
